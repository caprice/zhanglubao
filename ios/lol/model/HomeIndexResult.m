//
//  HomeIndexResult.m
//  lol
//
//  Created by Rocks on 15/9/5.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "HomeIndexResult.h"

@implementation HomeIndexResult

+ (NSDictionary *)objectClassInArray
{
    return @{
               @"slides" : @"SlideModel",
               @"hotvideos" : @"VideoModel",
               @"commvideos" : @"VideoModel",
               @"commusers" : @"UserModel",
               @"mastervideos" : @"VideoModel",
               @"masterusers" : @"UserModel",
               @"albumvideos" : @"VideoModel",
               @"videoalbums" : @"AlbumModel",
               @"matchvideos" : @"VideoModel",
               @"matchusers" : @"UserModel",
               @"othervideos" : @"VideoModel",
               
             };
}

@end
