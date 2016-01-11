//
//  UIImageView+Util.m
//  lol
//
//  Created by Rocks on 15/9/17.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "UIImageView+Util.h"
#import <SDWebImage/UIImageView+WebCache.h>

@implementation UIImageView (Util)



- (void)loadAvatar:(NSURL *)avatarURL{
     [self sd_setImageWithURL:avatarURL placeholderImage:[UIImage imageNamed:@"default_avatar"] options:0];
}
- (void)loadVideo:(NSURL *)videoURL{
    
    [self sd_setImageWithURL:videoURL placeholderImage:[UIImage imageNamed:@"default_video"] options:0];
}
- (void)loadAlbum:(NSURL *)albumURL{
    [self sd_setImageWithURL:albumURL placeholderImage:[UIImage imageNamed:@"default_album"] options:0];
}


@end
