//
//  XLBaseActivity.m
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "PagerBaseActivity.h"


@interface PagerBaseActivity ()
@end

@implementation PagerBaseActivity
- (void)viewDidLoad {
    [super viewDidLoad];
    UIImageView * imageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_logo"]];
    imageView.contentMode = UIViewContentModeScaleAspectFit;
    imageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *backItem = [[UIBarButtonItem alloc] initWithCustomView:imageView];
    self.navigationItem.leftBarButtonItem = nil;
    self.navigationItem.leftBarButtonItem = backItem;
    
    UIImageView * cacheImageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_down_unselected"]];
    cacheImageView.contentMode = UIViewContentModeScaleAspectFit;
    cacheImageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *cacheButton=[[UIBarButtonItem alloc] initWithCustomView:cacheImageView];
    
    UIImageView * favImageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_favorite_unselected"]];
    favImageView.contentMode = UIViewContentModeScaleAspectFit;
    favImageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *favButton=[[UIBarButtonItem alloc] initWithCustomView:favImageView];
    
    UIImageView * searchImageView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"sub_home_title_bar_search_unselected"]];
    searchImageView.contentMode = UIViewContentModeScaleAspectFit;
    searchImageView.autoresizingMask = UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight;
    UIBarButtonItem *searchButton=[[UIBarButtonItem alloc] initWithCustomView:searchImageView];
    
    
    NSArray *buttonArray = [[NSArray alloc]initWithObjects:cacheButton,favButton,searchButton, nil];
    self.navigationItem.rightBarButtonItems = buttonArray;
}
@end
