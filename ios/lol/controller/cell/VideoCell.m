//
//  VideoCell.m
//  lol
//
//  Created by Rocks on 15/9/5.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "VideoCell.h"
#import "VideoModel.h"
#import "UIImageView+WebCache.h"

@interface VideoCell ()

@property (nonatomic, strong) UILabel *titleLabel;
@property (nonatomic, strong) UIImageView *imageView;

@end


@implementation VideoCell
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
    CGFloat height = CGRectGetHeight(self.frame);
    _imageView.frame=CGRectMake(0, 0, width, height-34);
    _imageView.layer.cornerRadius=2;
     _imageView.layer.masksToBounds = YES;
    _titleLabel.frame=CGRectMake(0,height-34,width,34);
    
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
- (void)setVideo:(VideoModel *)video
{
    [_imageView sd_setImageWithURL:[NSURL URLWithString:video.video_picture] placeholderImage:[UIImage imageNamed:@"default_video_cover"]];
    [_titleLabel setText:video.video_title];
    
}
@end
