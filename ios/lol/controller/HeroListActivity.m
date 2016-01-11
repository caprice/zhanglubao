//
//  HeroListActivity.m
//  lol
//
//  Created by Rocks on 15/9/9.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "HeroListActivity.h"
#import "UIColor+Util.h"
#import "HeroModel.h"
#import "HeroListResult.h"
#import "HeroCell.h"
#import "CSCollectionViewFlowLayout.h"

static NSString * const kHeroCellID = @"HeroCell";

@interface HeroListActivity ()
@property (nonatomic, strong) NSMutableArray *heros;
@property (nonatomic,copy)    NSString        *url;
@property (nonatomic,assign)  int                 page;

@end

@implementation HeroListActivity
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
    [self.collectionView registerClass:[HeroCell class] forCellWithReuseIdentifier:kHeroCellID];
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
    return [_heros count];
}

//返回Cell
- (UICollectionViewCell *)collectionView:(UICollectionView *)collectionView cellForItemAtIndexPath:(NSIndexPath *)indexPath
{
    HeroCell   *cell = [collectionView dequeueReusableCellWithReuseIdentifier:kHeroCellID forIndexPath:indexPath];
    HeroModel *hero=[_heros objectAtIndex:indexPath.row];
    [cell setHero:hero];
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
    [_heros removeAllObjects];
    _page=0;
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    [manager GET:_url parameters:@{} success:^(AFHTTPRequestOperation *operation, NSDictionary *responseObject) {
        NSLog(@"%@", responseObject);
        HeroListResult *heroListResult=[HeroListResult objectWithKeyValues:responseObject];
        if (_heros) {
            [_heros addObjectsFromArray:heroListResult.heros];
        }else{
            _heros=heroListResult.heros;
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
        HeroListResult *heroListResult=[HeroListResult objectWithKeyValues:responseObject];
        if (_heros) {
            [_heros addObjectsFromArray:heroListResult.heros];
        }else{
            _heros=heroListResult.heros;
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
