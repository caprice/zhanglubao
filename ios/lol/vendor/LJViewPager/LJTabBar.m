
//  LJTabBar.m
//  LJViewPagerDemo
//
//  Created by Marco on 5/16/15.
//  Copyright (c) 2015 LJ. All rights reserved.
//

#import "LJTabBar.h"
#import "LJViewPager.h"
#import "UIColor+Util.h"

@interface LJTabBar ()

@property (strong, nonatomic) UIScrollView *scrollView;
@property (strong, nonatomic) UIView *tabContainerView;

@property (assign, nonatomic) CGFloat tabItemWidth;
@property (assign, nonatomic) CGFloat tabItemMinWidth;

@end

@implementation LJTabBar

- (instancetype)init {
    if (self == [super init]) {
        [self setup];
        
    }
    return self;
}

- (instancetype)initWithFrame:(CGRect)frame {
    if (self == [super initWithFrame:frame]) {
        [self setup];
        
    }
    return self;
}

- (instancetype)initWithCoder:(NSCoder *)aDecoder {
    if (self == [super initWithCoder:aDecoder]) {
        [self setup];
        
    }
    return self;
}

- (void)setup {
    
    self.scrollView = [[UIScrollView alloc] initWithFrame:self.bounds];
    self.scrollView.autoresizingMask = UIViewAutoresizingFlexibleHeight | UIViewAutoresizingFlexibleWidth;
    self.scrollView.contentSize = self.bounds.size;
    self.scrollView.bounces = NO;
    self.scrollView.showsHorizontalScrollIndicator = NO;
    self.scrollView.showsVerticalScrollIndicator = NO;
    [self addSubview:self.scrollView];
    
    self.tabContainerView = [[UIView alloc] initWithFrame:self.bounds];
    self.tabContainerView.autoresizingMask = UIViewAutoresizingFlexibleHeight | UIViewAutoresizingFlexibleWidth;
    [self.scrollView addSubview:self.tabContainerView];
    
    self.backgroundColor = [UIColor themeBgColor];
    self.textColor = [UIColor whiteColor];
    self.selectedTextColor = [UIColor whiteColor];
    self.tintColor = [UIColor whiteColor];
    self.textFont = [UIFont systemFontOfSize:16];
    self.indicatorColor = [UIColor whiteColor];
    self.separatorColor = self.backgroundColor;
    
    // shadow of tab bar
    UIBezierPath *shadowPath = [UIBezierPath bezierPathWithRect:self.bounds];
    self.layer.masksToBounds = NO;
    self.layer.shadowColor = [UIColor lightGrayColor].CGColor;
    self.layer.shadowOffset = CGSizeMake(0.0f, 3.0f);
    self.layer.shadowOpacity = 0.5f;
    self.layer.shadowPath = shadowPath.CGPath;
    
    self.itemsPerPage = 4;
    self.tabItemMinWidth = self.frame.size.width / self.itemsPerPage;
    
}

#pragma mark -
- (void)addTabAtIndex:(NSUInteger)index {
    int tabCount = ({
        int tabCount = 0;
        for (UIView *view in self.tabContainerView.subviews) {
            tabCount += view.tag >= 0;
        }
        tabCount;
    });
    float tabWidth = self.frame.size.width / (tabCount + 1);
    tabWidth = tabWidth < self.tabItemMinWidth ? self.tabItemMinWidth : tabWidth;
    float x = tabWidth * tabCount;
    float height = self.frame.size.height;
    
    int tab = 0;
    int separator = 1;
    for (int i = 0; i < self.tabContainerView.subviews.count; i++) {
        UIView *subView = self.tabContainerView.subviews[i];
        CGRect frame = subView.frame;
        if (subView.tag >= 0) { // tab button
            frame.origin.x = tabWidth * tab;
            frame.size.width = tabWidth;
            tab++;
        }
        if (subView.tag == -1) { // tab separator
            frame.origin.x = tabWidth * separator;
            separator++;
        }
        subView.frame = frame;
    }
    
    if (self.tabContainerView.subviews.count > 0) {
        float separatorX = x;
        float separatorY = 10;
        float separatorWidth = 1 / [UIScreen mainScreen].scale;
        float separatorHeight = height - separatorY * 2;
        CGRect separatorFrame = CGRectMake(separatorX, separatorY, separatorWidth, separatorHeight);
        UIView *separatorView = [[UIView alloc] initWithFrame:separatorFrame];
        separatorView.backgroundColor = self.separatorColor;
        separatorView.tag = -1;
        [self.tabContainerView addSubview:separatorView];
    }
    
    CGRect frame = CGRectMake(x, 0, tabWidth, height);
    UIButton *tabButton = [[UIButton alloc] initWithFrame:frame];
    tabButton.tag = index;
    
    UIImage *icon = self.iconImages.count >= index + 1 ? self.iconImages[index] : nil;
    if (icon) {
        NSAssert([icon isKindOfClass:[UIImage class]], @"icon image is not an UIImage object!");
        [tabButton setImage:icon forState:UIControlStateNormal];
        UIImage *selectedIcon = self.selectedIconImages.count >= index + 1 ? self.selectedIconImages[index] : nil;
        [tabButton setImage:selectedIcon forState:UIControlStateSelected];
    } else {
        UIViewController *vc = self.viewPager.viewControllers[index];
        NSString *title = self.titles.count >= index + 1 ? self.titles[index] : vc.title;
        [tabButton setTitle:title forState:UIControlStateNormal];
    }
    [tabButton setTitleColor:self.textColor forState:UIControlStateNormal];
    [tabButton setTitleColor:self.selectedTextColor forState:UIControlStateSelected];
    tabButton.tintColor = self.tintColor;
    tabButton.titleLabel.font = self.textFont;
    [tabButton addTarget:self action:@selector(tabPressed:) forControlEvents:UIControlEventTouchUpInside];
    [self.tabContainerView addSubview:tabButton];
    
    if (index >= self.itemsPerPage) {
        CGRect containerFrame = self.tabContainerView.frame;
        containerFrame.size.width = CGRectGetMaxX(tabButton.frame);
        self.tabContainerView.frame = containerFrame;
        self.scrollView.contentSize = containerFrame.size;
    }
    self.tabItemWidth = tabWidth;
}

- (void)addIndicatorView {
    float height = self.indicatorViewHeight > 0 ? self.indicatorViewHeight : 2;
    float y = self.frame.size.height - height;
    self.indicatorView = [[UIView alloc] initWithFrame:CGRectMake(0, y, self.tabItemWidth, height)];
    self.indicatorView.tag = -2;
    self.indicatorView.backgroundColor = self.indicatorColor;
    [self.tabContainerView addSubview:self.indicatorView];
}

- (void)selectedTabAtIndex:(NSInteger)index {
    int tab = ({
        int tab = 0;
        for (int i = 0; i < self.tabContainerView.subviews.count; i++) {
            UIView *subView = self.tabContainerView.subviews[i];
            if (subView.tag >= 0) {
                UIButton *tabButton = (UIButton *) subView;
                tabButton.selected = (index == tab);
                tab++;
            }
        }
        tab;
    });
    if (tab == 0) {
        return;
    }
    
    CGPoint scrollContentOffset = self.scrollView.contentOffset;
    if (index >= self.itemsPerPage) {
        float outScreenWidth = (index - (self.itemsPerPage - 1)) * self.tabItemWidth;
        if (outScreenWidth - scrollContentOffset.x > 0) {
            scrollContentOffset.x += self.tabItemWidth;
            float maxOffsetX = self.scrollView.contentSize.width - self.frame.size.width;
            scrollContentOffset.x = scrollContentOffset.x > maxOffsetX ? maxOffsetX : scrollContentOffset.x;
            [self.scrollView setContentOffset:scrollContentOffset animated:YES];
        }
    } else {
        float selectedTabX = self.tabItemWidth * index;
        if (selectedTabX - scrollContentOffset.x < 0) {
            scrollContentOffset.x -= self.tabItemWidth;
            scrollContentOffset.x  = scrollContentOffset.x < 0 ? 0 : scrollContentOffset.x;
            [self.scrollView setContentOffset:scrollContentOffset animated:YES];
        }
    }
    
    //CGRect indicatorViewFrame = self.indicatorView.frame;
    //indicatorViewFrame.origin.x = self.tabItemWidth * index;
    //self.indicatorView.frame = indicatorViewFrame;
}

- (void)resetTabs {
    for (UIView *view in self.tabContainerView.subviews) {
        [view removeFromSuperview];
    }
    for (int i = 0; i < self.viewPager.viewControllers.count; i++) {
        [self addTabAtIndex:i];
    }
    [self addIndicatorView];
    [self selectedTabAtIndex:0];
}

#pragma mark - action
- (void)tabPressed:(UIButton *)sender {
    if (self.viewPager) {
        self.selectedIndex = sender.tag;
        [self.viewPager scrollToPage:sender.tag];
    }
    if ([self.delegate respondsToSelector:@selector(tabBar:didSelectedItemAtIndex:)]) {
        [self.delegate tabBar:self didSelectedItemAtIndex:sender.tag];
    }
}

#pragma mark - getter and setter
- (void)setViewPager:(LJViewPager *)viewPager {
    _viewPager = viewPager;
    [self resetTabs];
}

- (void)setSelectedIndex:(NSUInteger)selectedIndex {
    _selectedIndex = selectedIndex;
    [self selectedTabAtIndex:selectedIndex];
}

- (void)setTitles:(NSArray *)titles {
    _titles = titles;
    [self resetTabs];
}

- (void)setTextFont:(UIFont *)textFont {
    _textFont = textFont;
    [self resetTabs];
}

- (void)setTextColor:(UIColor *)textColor {
    _textColor = textColor;
    [self resetTabs];
}

- (void)setSelectedTextColor:(UIColor *)selectedTextColor {
    _selectedTextColor = selectedTextColor;
    [self resetTabs];
}

- (void)setIndicatorColor:(UIColor *)indicatorColor {
    _indicatorColor = indicatorColor;
    [self resetTabs];
}

- (void)setSeparatorColor:(UIColor *)separatorColor {
    _separatorColor = separatorColor;
    [self resetTabs];
}

- (void)setShowShadow:(BOOL)showShadow {
    _showShadow = showShadow;
    self.layer.masksToBounds = !showShadow;
}

- (void)setShadowOffest:(CGSize)shadowOffest {
    _shadowOffest = shadowOffest;
    UIBezierPath *shadowPath = [UIBezierPath bezierPathWithRect:self.bounds];
    self.layer.shadowColor = self.shadowColor ? self.shadowColor.CGColor : [UIColor lightGrayColor].CGColor;
    self.layer.shadowOffset = shadowOffest;
    self.layer.shadowOpacity = 0.5f;
    self.layer.shadowPath = shadowPath.CGPath;
}

- (void)setShadowColor:(UIColor *)shadowColor {
    _shadowColor = shadowColor;
    UIBezierPath *shadowPath = [UIBezierPath bezierPathWithRect:self.bounds];
    self.layer.shadowColor = shadowColor.CGColor;
    self.layer.shadowOffset = CGSizeEqualToSize(self.shadowOffest, CGSizeZero) ? CGSizeMake(0.0f, 2.0f) : self.shadowOffest;
    self.layer.shadowOpacity = 0.5f;
    self.layer.shadowPath = shadowPath.CGPath;
}

- (void)setItemsPerPage:(NSInteger)itemsPerPage {
    _itemsPerPage = itemsPerPage;
    self.tabItemMinWidth = self.frame.size.width / self.itemsPerPage;
    [self resetTabs];
}

@end
