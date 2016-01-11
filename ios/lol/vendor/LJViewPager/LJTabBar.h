//
//  LJTabBar.h
//  LJViewPagerDemo
//
//  Created by Marco on 5/16/15.
//  Copyright (c) 2015 LJ. All rights reserved.
//

#import <UIKit/UIKit.h>

@class LJViewPager;
@class LJTabBar;

@protocol LJTabBarDelegate <NSObject>

- (void)tabBar:(LJTabBar *)tabBar didSelectedItemAtIndex:(NSUInteger)index;

@end

@interface LJTabBar : UIView

@property (weak, nonatomic) LJViewPager *viewPager;
@property (weak, nonatomic) id<LJTabBarDelegate> delegate;

/** default is 4 */
@property (assign, nonatomic) NSInteger itemsPerPage;

@property (assign, nonatomic) NSUInteger selectedIndex;

@property (strong, nonatomic) UIView *indicatorView;
@property (assign, nonatomic) CGFloat indicatorViewHeight;

@property (strong, nonatomic) NSArray *titles;
@property (strong, nonatomic) NSArray *iconImages;
@property (strong, nonatomic) NSArray *selectedIconImages;
@property (strong, nonatomic) UIFont *textFont;
@property (strong, nonatomic) UIColor *textColor;
@property (strong, nonatomic) UIColor *selectedTextColor;
@property (strong, nonatomic) UIColor *indicatorColor;
@property (strong, nonatomic) UIColor *separatorColor;

@property (assign, nonatomic) BOOL showShadow;
@property (assign, nonatomic) CGSize shadowOffest;
@property (strong, nonatomic) UIColor *shadowColor;


@end
