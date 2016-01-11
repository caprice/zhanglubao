//
//  BannerCell.h
//  lol
//
//  Created by Rocks on 15/9/7.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//

#import <UIKit/UIKit.h>
 

@class BannerCell;
@protocol BannerCellViewDelegate <NSObject>
- (void)bannerView:(BannerCell *)bannerView didSelectAtIndex:(NSUInteger)index;
@end


@interface BannerCell : UICollectionViewCell
@property (nonatomic, weak) id<BannerCellViewDelegate> delegate;
- (void)configBanner:(NSArray *)banners;
@end
