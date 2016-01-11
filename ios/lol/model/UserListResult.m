//
//  UserListResult.m
//  lol
//
//  Created by Rocks on 15/10/15.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "UserListResult.h"

@implementation UserListResult
+ (NSDictionary *)objectClassInArray
{
    return @{
             @"users" : @"UserModel",
             };
}
@end
