//
//  HomeActivity.m
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "HomeActivity.h"
#import "HomeIndexActivity.h"
#import "VideoListActivity.h"
#import "UIColor+Util.h"
#import "ZLBAPI.h"
#import "Utils.h"
#import "LJViewPager.h"
#import "LJTabBar.h"

@interface HomeActivity ()<LJViewPagerDataSource, LJViewPagerDelegate, UIScrollViewDelegate>

@property (strong, nonatomic) LJViewPager *viewPager;
@property (strong, nonatomic) LJTabBar *tabBar;

@end

@implementation HomeActivity


- (void)viewDidLoad {
    [super viewDidLoad];
    self.automaticallyAdjustsScrollViewInsets = NO;
    [self.view addSubview:self.viewPager];
    [self.view addSubview:self.tabBar];
    self.viewPager.viewPagerDateSource = self;
    self.viewPager.viewPagerDelegate = self;
    self.viewPager.delegate = self;
 
    self.tabBar.titles = @[NSLocalizedString(@"nav_home_index_index", nil), NSLocalizedString(@"nav_home_index_new", nil), NSLocalizedString(@"nav_home_index_comm", nil),NSLocalizedString(@"nav_home_index_album", nil),NSLocalizedString(@"nav_home_index_master", nil),NSLocalizedString(@"nav_home_index_match", nil),NSLocalizedString(@"nav_home_index_offical", nil),NSLocalizedString(@"nav_home_index_other", nil)];
  
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
       return [[HomeIndexActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_index", nil) url:ZLBURL(home_index_index)];
    }
    if (page==1) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_new", nil) url:ZLBURL(home_fresh_video)];
    }
    if (page==2) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_comm", nil) url:ZLBURL(home_comm_video)];
    }
    if (page==3) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_album", nil) url:ZLBURL(home_master_video)];
    }
    if (page==4) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_master", nil) url:ZLBURL(home_album_video)];
    }
    if (page==5) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_match", nil) url:ZLBURL(home_match_video)];
    }
    if (page==6) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_offical", nil) url:ZLBURL(home_owner_video)];
    }
    if (page==7) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_other", nil) url:ZLBURL(home_other_video)];
    }
    return [[HomeIndexActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_home_index_index", nil) url:ZLBURL(home_index_index)];
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
