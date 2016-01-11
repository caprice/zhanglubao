//
//  UserListActivity.m
//  lol
//
//  Created by Rocks on 15/9/9.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "UserListActivity.h"
#import "UIColor+Util.h"
#import "UserModel.h"
#import "UserListResult.h"
#import "UserCell.h"
#import "CSCollectionViewFlowLayout.h"

static NSString * const kUserCellID = @"UserCell";

@interface UserListActivity ()
@property (nonatomic, strong) NSMutableArray *users;
@property (nonatomic,copy)    NSString        *url;
@property (nonatomic,assign)  int                 page;

@end

@implementation UserListActivity
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
    
    
    _page=0;
    [self.collectionView registerClass:[UserCell class] forCellWithReuseIdentifier:kUserCellID];
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
    
    return 1;
}

- (NSInteger)collectionView:(UICollectionView *)collectionView numberOfItemsInSection:(NSInteger)section
{
    return [_users count];
}

//返回Cell
- (UICollectionViewCell *)collectionView:(UICollectionView *)collectionView cellForItemAtIndexPath:(NSIndexPath *)indexPath
{
    UserCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kUserCellID forIndexPath:indexPath];
    UserModel *user=[_users objectAtIndex:indexPath.row];
    [cell setUser:user];
    return cell;
    
}

-(UIEdgeInsets)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout insetForSectionAtIndex:(NSInteger)section
{
    
    return UIEdgeInsetsMake(6, 6, 6, 6);
    
}

//返回item的大小
-(CGSize)collectionView:(UICollectionView *)collectionView layout:(UICollectionViewLayout *)collectionViewLayout sizeForItemAtIndexPath:(NSIndexPath *)indexPath{
    
    CGFloat screenWidth = [UIScreen mainScreen].bounds.size.width;
    return CGSizeMake(screenWidth/4.0f-8.0f, 114);
    
}

#pragma mark <UICollectionViewDelegate>

- (void)collectionView:(UICollectionView *)collectionView didSelectItemAtIndexPath:(NSIndexPath *)indexPath
{
    
}

#pragma mark - 更新数据

- (void)refresh
{
    [_users removeAllObjects];
    _page=0;
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    [manager GET:_url parameters:@{} success:^(AFHTTPRequestOperation *operation, NSDictionary *responseObject) {
        NSLog(@"%@", responseObject);
        UserListResult *userlistresult=[UserListResult objectWithKeyValues:responseObject];
        if (_users) {
            [_users addObjectsFromArray:userlistresult.users];
        }else{
            _users=userlistresult.users;
        }
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
    [manager GET:_url parameters:dict success:^(AFHTTPRequestOperation *operation, NSDictionary *responseObject) {
        NSLog(@"%@", responseObject);
        UserListResult *userListResult=[UserListResult objectWithKeyValues:responseObject];
        if (_users) {
            [_users addObjectsFromArray:userListResult.users];
        }else{
            _users=userListResult.users;
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

