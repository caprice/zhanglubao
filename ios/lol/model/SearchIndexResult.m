//
//  SearchIndexResult.m
//  lol
//
//  Created by Rocks on 15/11/4.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "SearchIndexResult.h"

@implementation SearchIndexResult

+ (NSDictionary *)objectClassInArray
{
    return @{
             @"videos" : @"VideoModel",
             @"users" : @"UserModel",
             };
}

@end
