//
//  AppDelegate.m
//  lol
//
//  Created by Rocks on 15/8/20.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "AppDelegate.h"
#import "UIColor+Util.h"
#import "Rocks_ImageWithColor.h"

@interface AppDelegate ()

@end

@implementation AppDelegate

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    
    [application setStatusBarStyle:UIStatusBarStyleLightContent];
    [[UINavigationBar appearance] setBarTintColor:[UIColor themeBgColor]];
    
    
    [[UINavigationBar appearance] setBackgroundImage:[UIImage imageWithColor:[UIColor navBgColor]] forBarMetrics:UIBarMetricsDefault];
    [[UINavigationBar appearance] setShadowImage:[[UIImage alloc] init]];
    [[UINavigationBar appearance] setTranslucent:NO];
 
    
    
    [[UITabBar appearance] setTintColor:[UIColor tabFontColor]];
    [[UITabBarItem appearance] setTitleTextAttributes:@{NSForegroundColorAttributeName:[UIColor tabSelFontColor]} forState:UIControlStateSelected];
    
    return YES;
    
}


@end
