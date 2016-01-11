//
//  VideoListResult.m
//  lol
//
//  Created by Rocks on 15/10/14.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "VideoListResult.h"

@implementation VideoListResult
+ (NSDictionary *)objectClassInArray
{
    return @{
             @"videos" : @"VideoModel",
                    };
}
@end
