//
//  HomeIndexResult.h
//  lol
//
//  Created by Rocks on 15/9/5.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface HomeIndexResult : NSObject
@property (strong, nonatomic) NSMutableArray *slides;
@property (strong, nonatomic) NSMutableArray *hotvideos;
@property (strong, nonatomic) NSMutableArray *commvideos;
@property (strong, nonatomic) NSMutableArray *commusers;
@property (strong, nonatomic) NSMutableArray *mastervideos;
@property (strong, nonatomic) NSMutableArray *masterusers;
@property (strong, nonatomic) NSMutableArray *albumvideos;
@property (strong, nonatomic) NSMutableArray *videoalbums;
@property (strong, nonatomic) NSMutableArray *matchvideos;
@property (strong, nonatomic) NSMutableArray *matchusers;
@property (strong, nonatomic) NSMutableArray *othervideos;

@end
