//
//  HomeActivity.m
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "CategoryActivity.h"
#import "CategoryIndexActivity.h"
#import "UIColor+Util.h"
#import "ZLBAPI.h"
#import "Utils.h"
#import "LJViewPager.h"
#import "LJTabBar.h"
#import "UserListActivity.h"
#import "HeroListActivity.h"
#import "AlbumListActivity.h"


@interface CategoryActivity ()<LJViewPagerDataSource, LJViewPagerDelegate, UIScrollViewDelegate>

@property (strong, nonatomic) LJViewPager *viewPager;
@property (strong, nonatomic) LJTabBar *tabBar;

@end

@implementation CategoryActivity


- (void)viewDidLoad {
    [super viewDidLoad];
    self.automaticallyAdjustsScrollViewInsets = NO;
    [self.view addSubview:self.viewPager];
    [self.view addSubview:self.tabBar];
    self.viewPager.viewPagerDateSource = self;
    self.viewPager.viewPagerDelegate = self;
    self.viewPager.delegate = self;
    
   
    
    
    self.tabBar.titles = @[NSLocalizedString(@"nav_category_index_index", nil), NSLocalizedString(@"nav_category_index_hero", nil), NSLocalizedString(@"nav_category_index_comm", nil),NSLocalizedString(@"nav_category_index_album", nil),NSLocalizedString(@"nav_category_index_master", nil),NSLocalizedString(@"nav_category_index_pro", nil),NSLocalizedString(@"nav_category_index_team", nil),NSLocalizedString(@"nav_category_index_match", nil)];
    
    self.viewPager.tabBar = self.tabBar;
    
    
    
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    
    
}

#pragma mark - pager view data source
- (UIViewController *)viewPagerInViewController {
    return self;
}

- (NSInteger)numbersOfPage {
    return 8;
}

 

- (UIViewController *)viewPager:(LJViewPager *)viewPager controllerAtPage:(NSInteger)page {
    if (page==0) {
        return [[CategoryIndexActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_index", nil) url:ZLBURL(cate_home_index)];
    }
    if (page==1) {
        return [[HeroListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_hero", nil) url:ZLBURL(cate_hero_hero)];
    }
    if (page==2) {
        return [[UserListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_comm", nil) url:ZLBURL(cate_comm_user)];
    }
    if (page==3) {
        return [[AlbumListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_album", nil) url:ZLBURL(cate_album_album)];
    }
    if (page==4) {
        return [[UserListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_master", nil) url:ZLBURL(cate_master_user)];
    }
    if (page==5) {
        return [[UserListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_pro", nil) url:ZLBURL(cate_pro_user)];
    }
    if (page==6) {
        return [[UserListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_team", nil) url:ZLBURL(cate_team_user)];
    }
    if (page==7) {
        return [[UserListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_match", nil) url:ZLBURL(cate_match_user)];
    }
    return [[CategoryIndexActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_category_index_index", nil) url:ZLBURL(cate_home_index)];
}

#pragma mark - pager view delegate
- (void)viewPager:(LJViewPager *)viewPager didScrollToPage:(NSInteger)page {
}

- (void)viewPager:(LJViewPager *)viewPager didScrollToOffset:(CGPoint)offset {
    
}

#pragma mark - scrollview delegate
- (void)scrollViewDidScroll:(UIScrollView *)scrollView {
    
}

- (UIView *)tabBar {
    if (_tabBar == nil) {
        int tabHeight = 34;
        _tabBar = [[LJTabBar alloc] initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, tabHeight)];
        _tabBar.autoresizingMask = UIViewAutoresizingFlexibleWidth;
    }
    return _tabBar;
}

- (LJViewPager *)viewPager {
    if (_viewPager == nil) {
        _viewPager = [[LJViewPager alloc] initWithFrame:CGRectMake(0,
                                                                   CGRectGetMaxY(self.tabBar.frame),
                                                                   self.view.frame.size.width,
                                                                   self.view.frame.size.height - CGRectGetMaxY(self.tabBar.frame))];
        _viewPager.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    }
    return _viewPager;
}
 
@end