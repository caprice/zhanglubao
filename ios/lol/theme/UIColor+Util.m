//
//  UIColor+Util.m
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "UIColor+Util.h"
#import "Rocks_Color.h"
#import "AppDelegate.h"

@implementation UIColor (Util)

#pragma mark - Hex



#pragma mark - theme colors

+ (UIColor *)themeBgColor
{
    
    return RGB(255, 59, 0);
}

+ (UIColor *)navBgColor
{
   return RGB(255, 59, 0);
 
}
+ (UIColor *)navTextColor
{
    return RGB(219, 219, 219);
}

+ (UIColor *)tabBgColor{
    return [UIColor whiteColor];
}

+ (UIColor *)tabFontColor
{
      return RGB(255, 59, 0);
}
+ (UIColor *)tabSelFontColor
{
    return RGB(255, 59, 0);
}


+ (UIColor *)titleColor;
{
    return RGB(76, 76, 76);

    
}
+ (UIColor *)titleMoreColor{
    
    return RGB(151, 151, 151);

 
}
@end
