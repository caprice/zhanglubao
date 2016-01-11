//
//  BTPagesTableView.h
//  biketicket
//
//  Created by Marco on 12/27/14.
//  Copyright (c) 2014 bestapp. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "LJTabBar.h"

@class LJViewPager;

@protocol LJViewPagerDataSource <NSObject>

@required
/**
 * return the UIViewController which the view is add in
 */
- (UIViewController *)viewPagerInViewController;

- (NSInteger)numbersOfPage;

- (UIViewController *)viewPager:(LJViewPager *)viewPager
               controllerAtPage:(NSInteger)page;

@end

@protocol LJViewPagerDelegate <NSObject>

//- (void)viewPager:(LJViewPager *)viewPager willScrollToPage:(NSInteger)page;
- (void)viewPager:(LJViewPager *)viewPager didScrollToPage:(NSInteger)page;
- (void)viewPager:(LJViewPager *)viewPager didScrollToOffset:(CGPoint)offset;

@end

@interface LJViewPager : UIScrollView

@property (strong, nonatomic) LJTabBar *tabBar;

@property (weak, nonatomic) id<LJViewPagerDataSource> viewPagerDateSource;
@property (weak, nonatomic) id<LJViewPagerDelegate> viewPagerDelegate;

@property (strong, nonatomic) NSArray *viewControllers;
@property NSInteger currentPage;

- (void)reloadData;
/**
 * scroll to page with animated
 */
- (void)scrollToPage:(NSInteger)page;
- (void)scrollToPage:(NSInteger)page animated:(BOOL)animated;

@end
