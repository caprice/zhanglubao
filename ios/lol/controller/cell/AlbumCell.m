//
//  AlbumCell.m
//  lol
//
//  Created by Rocks on 15/9/5.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "AlbumCell.h"
#import "UIImageView+WebCache.h"
@interface AlbumCell ()

@property (nonatomic, strong) UILabel *titleLabel;
@property (nonatomic, strong) UIImageView *imageView;

@end

@implementation AlbumCell
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
    _titleLabel.numberOfLines=1;
    _titleLabel.textAlignment=NSTextAlignmentCenter;
    
    [self addSubview:_imageView];
    [self addSubview:_titleLabel];
    
    
}
- (void)setAlbum:(AlbumModel *)album
{
    [_imageView sd_setImageWithURL:[NSURL URLWithString:album.album_picture] placeholderImage:[UIImage imageNamed:@"default_album_cover"]];
    [_titleLabel setText:album.album_name];
    
}
@end