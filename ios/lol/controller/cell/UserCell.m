//
//  UserCell.m
//  lol
//
//  Created by Rocks on 15/9/5.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "UserCell.h"
#import "UserModel.h"
#import "UIImageView+WebCache.h"

@interface UserCell ()

@property (nonatomic, strong) UILabel *titleLabel;
@property (nonatomic, strong) UIImageView *imageView;

@end


@implementation UserCell
- (instancetype)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        [self initSubviews];
    }
    return self;
}
- (instancetype)initWithCoder:(NSCoder *)aDecoder
{
    self = [super initWithCoder: aDecoder];
    if (self) {
        [self initSubviews];
    }
    return self;
}

- (void)layoutSubviews{
    [super layoutSubviews];
    
    CGFloat width = CGRectGetWidth(self.frame);
 
    _imageView.frame=CGRectMake((width-80)/2, 0, 80, 80);
    _imageView.layer.cornerRadius=2;
    _imageView.layer.masksToBounds = YES;
    _titleLabel.frame=CGRectMake(0,80,width,34);
    _titleLabel.textAlignment=NSTextAlignmentCenter;
    
}
#pragma mark - private method
- (void)initSubviews{
    
    _imageView= [[UIImageView alloc]init];
    _titleLabel=[[UILabel alloc]init];
    _titleLabel.font = [UIFont systemFontOfSize:12];
    _titleLabel.numberOfLines=2;
    _titleLabel.textAlignment=NSTextAlignmentLeft;
    
    [self addSubview:_imageView];
    [self addSubview:_titleLabel];
     
    
}
- (void)setUser:(UserModel *)user
{
    [_imageView sd_setImageWithURL:[NSURL URLWithString:user.avatar] placeholderImage:[UIImage imageNamed:@"default_user_avatar"]];
    [_titleLabel setText:user.nickname];
    
}
@end
