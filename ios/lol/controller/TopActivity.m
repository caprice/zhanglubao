//
//  TopActivity.m
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "TopActivity.h"
#import "UIColor+Util.h"
#import "ZLBAPI.h"
#import "Utils.h"
#import "LJViewPager.h"
#import "LJTabBar.h"
#import "VideoListActivity.h"



@interface TopActivity ()<LJViewPagerDataSource, LJViewPagerDelegate, UIScrollViewDelegate>

@property (strong, nonatomic) LJViewPager *viewPager;
@property (strong, nonatomic) LJTabBar *tabBar;

@end

@implementation TopActivity


- (void)viewDidLoad {
    [super viewDidLoad];
    self.automaticallyAdjustsScrollViewInsets = NO;
    [self.view addSubview:self.viewPager];
    [self.view addSubview:self.tabBar];
    self.viewPager.viewPagerDateSource = self;
    self.viewPager.viewPagerDelegate = self;
    self.viewPager.delegate = self;
 
    
    
    self.tabBar.titles = @[NSLocalizedString(@"nav_top_day", nil), NSLocalizedString(@"nav_top_week", nil), NSLocalizedString(@"nav_top_month", nil),NSLocalizedString(@"nav_top_all", nil)];
    
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
    return 4;
}



- (UIViewController *)viewPager:(LJViewPager *)viewPager controllerAtPage:(NSInteger)page {
    if (page==0) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"VideoListActivity", nil) url:ZLBURL(top_day_video)];
    }
    if (page==1) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_top_week", nil) url:ZLBURL(top_week_video)];
    }
    if (page==2) {
        return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_top_month", nil) url:ZLBURL(top_month_video)];
    }
    
    return [[VideoListActivity alloc] initWithTitleUrl:NSLocalizedString(@"nav_top_all", nil) url:ZLBURL(top_all_video)];
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
