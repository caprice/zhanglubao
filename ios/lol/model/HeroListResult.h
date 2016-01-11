//
//  HeroListResult.h
//  lol
//
//  Created by Rocks on 15/10/15.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface HeroListResult : NSObject
@property (strong, nonatomic) NSMutableArray *heros;
@property (nonatomic,assign) NSNumber                 *status;
@end
