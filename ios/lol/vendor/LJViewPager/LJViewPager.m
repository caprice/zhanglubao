//
//  BTPagesTableView.m
//  biketicket
//
//  Created by Marco on 12/27/14.
//  Copyright (c) 2014 bestapp. All rights reserved.
//

#import "LJViewPager.h"
#import "LJTabBar.h"

@protocol UIScrollViewDelegateAdapter <UIScrollViewDelegate>

@end

@interface LJViewPager () <UIScrollViewDelegate>

@property UIViewController *viewController; // the UIViewController which the view is add in
@property NSMutableArray *mViewControllers;

@property id<UIScrollViewDelegateAdapter> delegateAdapter;

@end

@implementation LJViewPager

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

- (void)layoutSubviews {
    [super layoutSubviews];
    
    NSInteger page = [self.viewPagerDateSource numbersOfPage];
    CGSize contentSize = CGSizeMake(CGRectGetWidth(self.frame) * page, CGRectGetHeight(self.frame));
    self.contentSize = contentSize;
    
    for (int i = 0; i < self.subviews.count; i++) {
        UIView *view = self.subviews[i];
        CGRect frame = view.frame;
        frame.origin.y = 0;
        frame.origin.x = CGRectGetWidth(self.frame) * i;
        frame.size.width = CGRectGetWidth(self.frame);
        frame.size.height = CGRectGetHeight(self.frame);
        view.frame = frame;
    }
    
}

- (void)setup {
    
    self.mViewControllers = [NSMutableArray array];
    
    self.pagingEnabled = YES;
    self.alwaysBounceVertical = NO;
    self.alwaysBounceHorizontal = NO;
    self.showsHorizontalScrollIndicator = NO;
    self.showsVerticalScrollIndicator = NO;
    self.delegate = self;
    
}

#pragma mark -
- (void)reloadData {
    if ([self.viewPagerDateSource respondsToSelector:@selector(viewPagerInViewController)]) {
        self.viewController = [self.viewPagerDateSource viewPagerInViewController];
        if (self.viewController.navigationController != nil) {
            // make the ScreenEdgePanGesture recognizer first
            UIGestureRecognizer *gr = [self screenEdgePanGestureRecognizer:self.viewController.navigationController];
            [self.panGestureRecognizer requireGestureRecognizerToFail:gr];
        }
    }
    
    for (int i = 0; i < self.mViewControllers.count; i++) {
        UITableViewController *vc = self.mViewControllers[i];
        [vc removeFromParentViewController];
        [vc.view removeFromSuperview];
    }
    [self.mViewControllers removeAllObjects];
    
    if (self.viewPagerDateSource == nil) {
        return;
    }
    
    NSInteger page = 0;
    if ([self.viewPagerDateSource respondsToSelector:@selector(numbersOfPage)]) {
        page = [self.viewPagerDateSource numbersOfPage];
    }
    CGSize contentSize = CGSizeMake(CGRectGetWidth(self.frame) * page, CGRectGetHeight(self.frame));
    self.contentSize = contentSize;
    
    for (int i = 0; i < page; i++) {
        UIViewController *viewController;
        if ([self.viewPagerDateSource respondsToSelector:@selector(viewPager:controllerAtPage:)]) {
            viewController = [self.viewPagerDateSource viewPager:self controllerAtPage:i];
        }
        if (viewController != nil) {
            
            [self.mViewControllers addObject:viewController];
            
            [self.viewController addChildViewController:viewController];
            CGRect frame = viewController.view.frame;
            frame.origin.y = 0;
            frame.origin.x = CGRectGetWidth(self.frame) * i;
            frame.size.width = CGRectGetWidth(self.frame);
            frame.size.height = CGRectGetHeight(self.frame);
            viewController.view.frame = frame;
            [self addSubview:viewController.view];
            
        }
        
    }
    self.viewControllers = self.mViewControllers;
    self.tabBar.viewPager = self;
    
}

- (void)scrollToPage:(NSInteger)page {
    if (self.currentPage == page) {
        return;
    }
    self.currentPage = page;
    int offsetX = CGRectGetWidth(self.frame) * page;
    if (offsetX < self.contentSize.width) {
        
        CGPoint offset = CGPointMake(offsetX, 0);
        [self setContentOffset:offset animated:YES];
        
    }
    [self endViewControllerEditing];
    self.tabBar.selectedIndex = page;
}

- (void)scrollToPage:(NSInteger)page animated:(BOOL)animated {
    if (self.currentPage == page) {
        return;
    }
    self.currentPage = page;
    int offsetX = CGRectGetWidth(self.frame) * page;
    if (offsetX < self.contentSize.width) {
        
        CGPoint offset = CGPointMake(offsetX, 0);
        [self setContentOffset:offset animated:animated];
        
    }
    [self endViewControllerEditing];
    self.tabBar.selectedIndex = page;
}

#pragma mark - scroll view delegate
- (void)scrollViewDidScroll:(UIScrollView *)scrollView {
    if ([self.viewPagerDelegate respondsToSelector:@selector(viewPager:didScrollToOffset:)]) {
        [self.viewPagerDelegate viewPager:self didScrollToOffset:scrollView.contentOffset];
    }
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidScroll:)]) {
        [self.delegateAdapter scrollViewDidScroll:scrollView];
    }
    if (self.tabBar) {
        CGRect tabIndicatorFrame = self.tabBar.indicatorView.frame;
        tabIndicatorFrame.origin.x = scrollView.contentOffset.x / self.tabBar.itemsPerPage;
        self.tabBar.indicatorView.frame = tabIndicatorFrame;
    }
}

- (void)scrollViewDidZoom:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidZoom:)]) {
        [self.delegateAdapter scrollViewDidZoom:scrollView];
    }
}

- (void)scrollViewWillBeginDragging:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewWillBeginDragging:)]) {
        [self.delegateAdapter scrollViewWillBeginDragging:scrollView];
    }
}

- (void)scrollViewDidEndDragging:(UIScrollView *)scrollView willDecelerate:(BOOL)decelerate {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidEndDragging:willDecelerate:)]) {
        [self.delegateAdapter scrollViewDidEndDragging:scrollView willDecelerate:decelerate];
    }
}

- (void)scrollViewWillBeginDecelerating:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewWillBeginDecelerating:)]) {
        [self.delegateAdapter scrollViewWillBeginDecelerating:scrollView];
    }
}

- (void)scrollViewDidEndDecelerating:(UIScrollView *)scrollView {
    int offsetX = scrollView.contentOffset.x;
    int page = offsetX / (int)CGRectGetWidth(self.frame);
    
    if (self.currentPage == page) {
        return;
    }
    self.currentPage = page;
    [self endViewControllerEditing];
    if ([self.viewPagerDelegate respondsToSelector:@selector(viewPager:didScrollToPage:)]) {
        [self.viewPagerDelegate viewPager:self didScrollToPage:page];
    }
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidEndDecelerating:)]) {
        [self.delegateAdapter scrollViewDidEndDecelerating:scrollView];
    }
    self.tabBar.selectedIndex = page;
}

- (void)scrollViewDidEndScrollingAnimation:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidEndScrollingAnimation:)]) {
        [self.delegateAdapter scrollViewDidEndScrollingAnimation:scrollView];
    }
}

- (UIView *)viewForZoomingInScrollView:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(viewForZoomingInScrollView:)]) {
        return [self.delegateAdapter viewForZoomingInScrollView:scrollView];
    }
    return nil;
}

- (void)scrollViewWillBeginZooming:(UIScrollView *)scrollView withView:(UIView *)view {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewWillBeginZooming:withView:)]) {
        [self.delegateAdapter scrollViewWillBeginZooming:scrollView withView:view];
    }
}
- (void)scrollViewDidEndZooming:(UIScrollView *)scrollView withView:(UIView *)view atScale:(CGFloat)scale {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidEndZooming:withView:atScale:)]) {
        [self.delegateAdapter scrollViewDidEndZooming:scrollView withView:view atScale:scale];
    }
}

- (BOOL)scrollViewShouldScrollToTop:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewShouldScrollToTop:)]) {
        return [self.delegateAdapter scrollViewShouldScrollToTop:scrollView];
    }
    return YES;
}

- (void)scrollViewDidScrollToTop:(UIScrollView *)scrollView {
    if ([self.delegateAdapter respondsToSelector:@selector(scrollViewDidScrollToTop:)]) {
        [self.delegateAdapter scrollViewDidScrollToTop:scrollView];
    }
}

#pragma mark - private methods
- (void)endViewControllerEditing {
    for (int i = 0; i < self.mViewControllers.count; i++) {
        UITableViewController *vc = self.mViewControllers[i];
        [vc.view endEditing:YES];
    }
}

- (UIScreenEdgePanGestureRecognizer *)screenEdgePanGestureRecognizer:(UINavigationController *)controller {
    UIScreenEdgePanGestureRecognizer *screenEdgePanGestureRecognizer = nil;
    if (controller.view.gestureRecognizers.count > 0) {
        for (UIGestureRecognizer *recognizer in controller.view.gestureRecognizers) {
            if ([recognizer isKindOfClass:[UIScreenEdgePanGestureRecognizer class]]) {
                screenEdgePanGestureRecognizer = (UIScreenEdgePanGestureRecognizer *)recognizer;
                break;
            }
        }
    }
    return screenEdgePanGestureRecognizer;
}

#pragma mark - setter and getter
- (void)setViewPagerDateSource:(id<LJViewPagerDataSource>)viewPagerDateSource {
    _viewPagerDateSource = viewPagerDateSource;
    [self reloadData];
}

- (void)setDelegate:(id<UIScrollViewDelegate>)delegate {
    if (self.delegate == nil) {
        [super setDelegate:delegate];
        return;
    }
    _delegateAdapter = (id<UIScrollViewDelegateAdapter>) delegate;
}

- (void)setTabBar:(LJTabBar *)tabBar {
    _tabBar = tabBar;
    _tabBar.viewPager = self;
}

@end
