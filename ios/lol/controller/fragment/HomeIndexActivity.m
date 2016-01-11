//
//  HomeIndexActivity.m
//  lol
//
//  Created by Rocks on 15/8/24.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "HomeIndexActivity.h"
#import "MJExtension.h"
#import <SDWebImage/UIImageView+WebCache.h>


#import "UIColor+Util.h"

#import "VideoModel.h"
#import "UserModel.h"
#import "AlbumModel.h"
#import "SlideModel.h"
#import "HomeIndexResult.h"
#import "VideoCell.h"
#import "UserCell.h"
#import "AlbumCell.h"
#import "BannerCell.h"
#import "HomeIndexResult.h"
#import "TitleView.h"
#import "CSCollectionViewFlowLayout.h"
#import "VideoListResult.h"


static NSString * const kBannerCellID = @"BannerCell";
static NSString * const kUserCellID = @"UserCell";
static NSString * const kVideoCellID = @"VideoCell";

static NSString * const kAlbumCellID = @"AlbumCell";
static NSString * const kTitleViewID = @"TitleView";

@interface HomeIndexActivity ()
@property (nonatomic, strong) NSMutableArray *newvideos;
@property (nonatomic, strong) HomeIndexResult *homeIndexResult;
@property (nonatomic,copy) NSString                 *url;
@property (nonatomic,assign) int                 page;
@end

@implementation HomeIndexActivity


- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];

}


#pragma mark 



- (instancetype)initWithTitleUrl:(NSString *)title url:(NSString *)url
{
    self= [super init];
    
    if (self) {
        self.controllerTitle = title;
        self.url= url;
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
   
    
    _page=-1;
     [self.collectionView registerClass:[VideoCell class] forCellWithReuseIdentifier:kVideoCellID];
    [self.collectionView registerClass:[UserCell class] forCellWithReuseIdentifier:kUserCellID];
    [self.collectionView registerClass:[BannerCell class] forCellWithReuseIdentifier:kBannerCellID];
     [self.collectionView registerClass:[AlbumCell class] forCellWithReuseIdentifier:kAlbumCellID];
    [self.collectionView registerClass:[TitleView class] forSupplementaryViewOfKind:UICollectionElementKindSectionHeader withReuseIdentifier:kTitleViewID];
  
    
    self.collectionView.backgroundColor = [UIColor whiteColor];
    
      self.collectionView.header = ({
        MJRefreshNormalHeader *header = [MJRefreshNormalHeader headerWithRefreshingTarget:self refreshingAction:@selector(refresh)];
        header.lastUpdatedTimeLabel.hidden = YES;
        header;
    });
    
    // 上拉刷新
    self.collectionView.footer = [MJRefreshAutoNormalFooter footerWithRefreshingTarget:self refreshingAction:@selector(loadmore)];
    // 默认先隐藏footer
    self.collectionView.footer.hidden = YES;
     [self.collectionView.header beginRefreshing];
}

 


#pragma mark <UICollectionViewDataSource>


- (NSInteger)numberOfSectionsInCollectionView:(UICollectionView *)collectionView
{
    if (_newvideos!=nil&&[_newvideos count]>0) {
        return 12;
    }
    if (_homeIndexResult) {
        return 11;
    }
    return 0;
}


- (NSInteger)collectionView:(UICollectionView *)collectionView numberOfItemsInSection:(NSInteger)section
{
    if (section==0) {
        return 1;
    }
    if (_homeIndexResult) {
        
        switch (section) {
            case 1:
                return [_homeIndexResult.hotvideos count];
                break;
            case 2:
                return [_homeIndexResult.commvideos count];
                break;
            case 3:
                return [_homeIndexResult.commusers count];
                break;
            case 4:
                return [_homeIndexResult.mastervideos count];
                break;
            case 5:
                return [_homeIndexResult.masterusers count];
                break;
            case 6:
                return [_homeIndexResult.albumvideos count];
                break;
            case 7:
                return [_homeIndexResult.videoalbums count];
                break;
            case 8:
                return [_homeIndexResult.matchvideos count];
                break;
            case 9:
                return [_homeIndexResult.matchusers count];
                break;
            case 10:
                return [_homeIndexResult.othervideos count];
                break;
            case 11:
                return [_newvideos count];
                break;
                
            default:
                return 0;
                break;
        }
    }else{
        return 0;
    }
}
//返回Cell
- (UICollectionViewCell *)collectionView:(UICollectionView *)collectionView cellForItemAtIndexPath:(NSIndexPath *)indexPath
{
    if (indexPath.section==0) {
        BannerCell *banner=[collectionView dequeueReusableCellWithReuseIdentifier:kBannerCellID forIndexPath:indexPath];
        [banner configBanner:_homeIndexResult.slides];
        return banner;
        
    }
    if (indexPath.section==1) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        
        VideoModel *video=[_homeIndexResult.hotvideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
 
    if (indexPath.section==2) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[_homeIndexResult.commvideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
   
    if (indexPath.section==3) {
        UserCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kUserCellID forIndexPath:indexPath];
        UserModel *user=[_homeIndexResult.commusers objectAtIndex:indexPath.row];
        [cell setUser:user];
        return cell;
    }
    if (indexPath.section==4) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[_homeIndexResult.mastervideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
    if (indexPath.section==5) {
        UserCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kUserCellID forIndexPath:indexPath];
        UserModel *user=[_homeIndexResult.masterusers objectAtIndex:indexPath.row];
        [cell setUser:user];
        return cell;
    }

    
    if (indexPath.section==6) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[_homeIndexResult.albumvideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
    
    if (indexPath.section==7) {
        AlbumCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kAlbumCellID forIndexPath:indexPath];
        AlbumModel *album=[_homeIndexResult.videoalbums objectAtIndex:indexPath.row];
        [cell setAlbum:album];
        return cell;
    }
    if (indexPath.section==8) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[_homeIndexResult.mastervideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
    
    if (indexPath.section==9) {
        UserCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kUserCellID forIndexPath:indexPath];
        UserModel *user=[_homeIndexResult.matchusers objectAtIndex:indexPath.row];
        [cell setUser:user];
        return cell;
    }
    if (indexPath.section==10) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[_homeIndexResult.othervideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }

    if (indexPath.section==11&&_newvideos!=nil&&[_newvideos count]>0) {
        VideoCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kVideoCellID forIndexPath:indexPath];
        VideoModel *video=[self.newvideos objectAtIndex:indexPath.row];
        [cell setVideo:video];
        return cell;
    }
 
    return nil;
    
}

-(UIEdgeInsets)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout insetForSectionAtIndex:(NSInteger)section
{
    if (section==0) {
        return UIEdgeInsetsMake(0, 0, 0, 0);

    }
       return UIEdgeInsetsMake(6, 6, 6, 6);
   
}

//返回item的大小
-(CGSize)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout sizeForItemAtIndexPath:(NSIndexPath *)indexPath{
    if (indexPath.row==0&&indexPath.section==0) {
        CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
        return CGSizeMake(screenWidth, 110);
    }
    if (indexPath.section==1||indexPath.section==2||indexPath.section==4||indexPath.section==6||indexPath.section==8||indexPath.section==10||indexPath.section==11) {
        CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
        return CGSizeMake(screenWidth/2.0f-8.0f, (screenWidth/1.9f)*0.5+34.0f);
    }
    if (indexPath.section==3||indexPath.section==5||indexPath.section==9) {
        CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
        return CGSizeMake(screenWidth/4.0f-8.0f, 114);
    }
    if(indexPath.section==7)
    {
        CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
        return CGSizeMake(screenWidth/3.0f-8.0f, (screenWidth/3.0f)*1.508);
    }
    
    
    CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
    return CGSizeMake(screenWidth/2.0f-8.0f, (screenWidth/2.0f)*0.5+34.0f);
}

//返回HeaderView的大小
-(CGSize)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout referenceSizeForHeaderInSection:(NSInteger)section{
    CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
    if (section==0) {
        return CGSizeMake(screenWidth, 0);
    }else return CGSizeMake(screenWidth, 40);
}

//返回每个分区的headerView
-(UICollectionReusableView *)collectionView:(UICollectionView *)collectionView viewForSupplementaryElementOfKind:(NSString *)kind atIndexPath:(NSIndexPath *)indexPath{
    
    if (indexPath.section!=0&&[kind isEqualToString:UICollectionElementKindSectionHeader]) {
  
        TitleView *titleView=[collectionView dequeueReusableSupplementaryViewOfKind:UICollectionElementKindSectionHeader withReuseIdentifier:kTitleViewID forIndexPath:indexPath];
        NSString *title;
        NSString *moreTitle;
      
        switch (indexPath.section) {
            case 1:
                title=NSLocalizedString(@"content_home_index_hot", nil);
                moreTitle=NSLocalizedString(@"content_home_index_hot_more", nil);
                break;
            case 2:
                title=NSLocalizedString(@"content_home_index_comm", nil);
                moreTitle=NSLocalizedString(@"content_home_index_comm_more", nil);
                break;
            case 3:
                title=NSLocalizedString(@"content_home_index_comm_user", nil);
                moreTitle=NSLocalizedString(@"content_home_index_comm_user_more", nil);
                break;
            case 4:
                title=NSLocalizedString(@"content_home_index_master", nil);
                moreTitle=NSLocalizedString(@"content_home_index_master_more", nil);
                break;
            case 5:
                title=NSLocalizedString(@"content_home_index_master_user", nil);
                moreTitle=NSLocalizedString(@"content_home_index_master_more", nil);
                break;
            case 6:
                title=NSLocalizedString(@"content_home_index_album", nil);
                moreTitle=NSLocalizedString(@"content_home_index_album_more", nil);
                break;
            case 7:
                title=NSLocalizedString(@"content_home_index_album_album", nil);
                moreTitle=NSLocalizedString(@"content_home_index_album_album_more", nil);
                break;
            case 8:
                title=NSLocalizedString(@"content_home_index_match", nil);
                moreTitle=NSLocalizedString(@"content_home_index_match_more", nil);
                break;
            case 9:
                title=NSLocalizedString(@"content_home_index_match_user", nil);
                moreTitle=NSLocalizedString(@"content_home_index_match_user_more", nil);
                break;
            case 10:
                title=NSLocalizedString(@"content_home_index_other", nil);
                moreTitle=NSLocalizedString(@"content_home_index_other_more", nil);
                break;
            case 11:
                title=NSLocalizedString(@"content_home_index_more", nil);
                moreTitle=NSLocalizedString(@"content_home_index_more_more", nil);
                break;
            default:
                break;
        }
        [titleView setTitleText:title];
        [titleView setMoreText:moreTitle];
        return titleView;
    }
    return nil;
    
}




#pragma mark <UICollectionViewDelegate>

- (void)collectionView:(UICollectionView *)collectionView didSelectItemAtIndexPath:(NSIndexPath *)indexPath
{
    
}

#pragma mark - 更新数据

- (void)refresh
{
    [_newvideos removeAllObjects];
    _page=-1;
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    [manager GET:_url parameters:@{} success:^(AFHTTPRequestOperation *operation, NSDictionary *responseObject) {
        NSLog(@"%@", responseObject);
        _homeIndexResult=[HomeIndexResult objectWithKeyValues:responseObject];
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

#pragma mark - 获取更多

-(void)loadmore
{
    _page=_page+1;
    NSDictionary *dict = @{@"page": [NSString stringWithFormat:@"%d", _page]};
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    [manager GET:ZLBURL(home_fresh_video) parameters:dict success:^(AFHTTPRequestOperation *operation, NSDictionary *responseObject) {
        NSLog(@"%@", responseObject);
        VideoListResult *videolistresult=[VideoListResult objectWithKeyValues:responseObject];
        if (_newvideos) {
            [_newvideos addObjectsFromArray:videolistresult.videos];
        }else{
            _newvideos=videolistresult.videos;
        }
        
        [self.collectionView.footer endRefreshing];
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


