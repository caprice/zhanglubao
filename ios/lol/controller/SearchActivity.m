//
//  SearchActivity.m
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "SearchActivity.h"

#import "UIColor+Util.h"
#import "VideoModel.h"
#import "VideoListResult.h"
#import "VideoCell.h"
#import "CSCollectionViewFlowLayout.h"
#import "ZLBAPI.h"
#import "UserCell.h"
#import "SearchIndexResult.h"


static NSString * const kVideoCellID = @"VideoCell";
static NSString * const kUserCellID = @"UserCell";
@interface SearchActivity ()
@property (nonatomic, strong) SearchIndexResult *searchIndexResult;
@property (nonatomic,copy)    NSString        *url;
@property (nonatomic,assign)  int                 page;

@end

@implementation SearchActivity
- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    
}


#pragma mark
- (instancetype)init
{
    self= [super init];
    
    if (self) {
        self.url= ZLBURL(search_index_index);
        CSCollectionViewFlowLayout *flowLayout = [CSCollectionViewFlowLayout new];
        flowLayout.minimumInteritemSpacing=0;
        flowLayout.minimumLineSpacing=2;
        self = [super initWithCollectionViewLayout:flowLayout];
        self.hidesBottomBarWhenPushed = YES;
        self.collectionView.showsVerticalScrollIndicator=NO;
    }
    
    return self;
}

- (void)viewDidLoad {
    [super viewDidLoad];
    
    UIImageView * imageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_logo"]];
    imageView.contentMode = UIViewContentModeScaleAspectFit;
    imageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *backItem = [[UIBarButtonItem alloc] initWithCustomView:imageView];
    self.navigationItem.leftBarButtonItem = nil;
    self.navigationItem.leftBarButtonItem = backItem;
    
    UIImageView * cacheImageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_down_unselected"]];
    cacheImageView.contentMode = UIViewContentModeScaleAspectFit;
    cacheImageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *cacheButton=[[UIBarButtonItem alloc] initWithCustomView:cacheImageView];
    
    UIImageView * favImageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_favorite_unselected"]];
    favImageView.contentMode = UIViewContentModeScaleAspectFit;
    favImageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *favButton=[[UIBarButtonItem alloc] initWithCustomView:favImageView];
    
    UIImageView * searchImageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_search_unselected"]];
    searchImageView.contentMode = UIViewContentModeScaleAspectFit;
    searchImageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *searchButton=[[UIBarButtonItem alloc] initWithCustomView:searchImageView];
    
    
    NSArray *buttonArray = [[NSArray alloc]initWithObjects:cacheButton,favButton,searchButton, nil];
    self.navigationItem.rightBarButtonItems = buttonArray;
 
    _page=0;
    [self.collectionView registerClass:[VideoCell class] forCellWithReuseIdentifier:kVideoCellID];
     [self.collectionView registerClass:[UserCell class] forCellWithReuseIdentifier:kUserCellID];
    self.collectionView.backgroundColor = [UIColor whiteColor];
    
    self.collectionView.header = ({
        MJRefreshNormalHeader *header = [MJRefreshNormalHeader headerWithRefreshingTarget:self refreshingAction:@selector(refresh)];
        header.lastUpdatedTimeLabel.hidden = YES;
        header;
    });
 
    // 默认先隐藏footer
    self.collectionView.footer.hidden = YES;
    [self.collectionView.header beginRefreshing];
}




#pragma mark <UICollectionViewDataSource>


- (NSInteger)numberOfSectionsInCollectionView:(UICollectionView *)collectionView
{
    
    return 2;
}

- (NSInteger)collectionView:(UICollectionView *)collectionView numberOfItemsInSection:(NSInteger)section
{
    if (section==0) {
         return [_searchIndexResult.videos count];
    }
    if (section==1) {
        return [_searchIndexResult.users count];
    }
    return 0;
   
}

//返回Cell
- (UICollectionViewCell *)collectionView:(UICollectionView *)collectionView cellForItemAtIndexPath:(NSIndexPath *)indexPath
{
    if(indexPath.section==0)
    {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[_searchIndexResult.videos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
    if(indexPath.section==1)
    {
        UserCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kUserCellID forIndexPath:indexPath];
        UserModel *user=[_searchIndexResult.videos objectAtIndex:indexPath.row];
        [cell setUser:user];
        return cell;
    }
    return  nil;
    
}

-(UIEdgeInsets)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout insetForSectionAtIndex:(NSInteger)section
{
    
    return UIEdgeInsetsMake(6, 6, 6, 6);
    
}

//返回item的大小
-(CGSize)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout sizeForItemAtIndexPath:(NSIndexPath *)indexPath{
    
    if (indexPath.section==0) {
        CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
        return CGSizeMake(screenWidth/2.0f-8.0f, (screenWidth/1.9f)*0.5+34.0f);
    }
    if (indexPath.section==1) {
        CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
        return CGSizeMake(screenWidth/4.0f-8.0f, 114);
    }
    CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
    return CGSizeMake(screenWidth/2.0f-8.0f, (screenWidth/1.9f)*0.5+34.0f);}

#pragma mark <UICollectionViewDelegate>

- (void)collectionView:(UICollectionView *)collectionView didSelectItemAtIndexPath:(NSIndexPath *)indexPath
{
    
}

#pragma mark - 更新数据

- (void)refresh
{
     
    _page=0;
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    [manager GET:_url parameters:@{} success:^(AFHTTPRequestOperation *operation, NSDictionary *responseObject) {
        NSLog(@"%@", responseObject);
       _searchIndexResult=[SearchIndexResult objectWithKeyValues:responseObject];
    
        [self.collectionView.header endRefreshing];
        dispatch_async(dispatch_get_main_queue(), ^{
            [self.collectionView reloadData];
        });
        NSLog(@"%@", [NSThread currentThread]);
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"%@", error);
        [self.collectionView.header endRefreshing];
    }];
}



@end
