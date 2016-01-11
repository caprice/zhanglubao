//
//  CategoryIndexResult.m
//  lol
//
//  Created by Rocks on 15/10/15.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "CategoryIndexResult.h"

@implementation CategoryIndexResult
 

+ (NSDictionary *)objectClassInArray
{
    return @{
             @"heros" : @"HeroModel",
             @"comms" : @"UserModel",
             @"masters" : @"UserModel",
             @"pros" : @"UserModel",
             @"teams" : @"UserModel",
             @"matches" : @"UserModel",
             @"albums" : @"AlbumModel",
             };
}


@end
