//
//  TitleView.m
//  lol
//
//  Created by Rocks on 15/9/11.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import "TitleView.h"
#import "UIColor+Util.h"

@interface TitleView ()

@property (nonatomic, strong) UILabel *titleLabel;
@property (nonatomic, strong) UILabel *moreLabel;
@property (nonatomic, strong) UIView *lineView;

@end

@implementation TitleView

- (instancetype)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        [self initSubviews];
        [self initLayout];
    }
    return self;
}

- (void)initSubviews
{
    
    _titleLabel = [UILabel new];
    _titleLabel.numberOfLines = 0;
    _titleLabel.lineBreakMode = NSLineBreakByWordWrapping;
    _titleLabel.font = [UIFont boldSystemFontOfSize:16];
    _titleLabel.textColor = [UIColor titleColor];
    [self addSubview:_titleLabel];
    
    _moreLabel = [UILabel new];
    _moreLabel.font = [UIFont systemFontOfSize:13];
    _moreLabel.textColor = [UIColor titleMoreColor];
    [self addSubview:_moreLabel];
}
- (void)initLayout
{
    for (UIView *view in [self subviews]) {
        view.translatesAutoresizingMaskIntoConstraints = NO;
    }
    
    
    [self addConstraints:[NSLayoutConstraint constraintsWithVisualFormat:@"V:|-15-[_titleLabel]-15-|" options:NSLayoutFormatAlignAllCenterY metrics:nil views:NSDictionaryOfVariableBindings(_titleLabel)]];
    
    [self addConstraints:[NSLayoutConstraint constraintsWithVisualFormat:@"H:|-6-[_titleLabel]-15-|" options:NSLayoutFormatAlignAllCenterY metrics:nil views:NSDictionaryOfVariableBindings(_titleLabel)]];
    
   [self addConstraints:[NSLayoutConstraint constraintsWithVisualFormat:@"V:|-15-[_moreLabel]-15-|" options:NSLayoutFormatAlignAllCenterY metrics:nil views:NSDictionaryOfVariableBindings(_moreLabel)]];
    
      [self addConstraints:[NSLayoutConstraint constraintsWithVisualFormat:@"H:[_moreLabel]-10-|" options:0 metrics:nil views:NSDictionaryOfVariableBindings(_moreLabel)]];
 

}

- (void) setTitleText:(NSString *)text{
    
    [_titleLabel setText:text];
}
- (void) setMoreText:(NSString *)text{
    [_moreLabel setText:text];
}

@end
