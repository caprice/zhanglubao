//
//  AlbumListResult.m
//  lol
//
//  Created by Rocks on 15/10/15.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "AlbumListResult.h"

@implementation AlbumListResult
+ (NSDictionary *)objectClassInArray
{
    return @{
             @"albums" : @"AlbumModel",
             };
}

@end
