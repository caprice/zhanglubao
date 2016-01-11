//
//  Rocks_Color.h
//  lol
//
//  Created by Rocks on 15/8/21.
//  Copyright (c) 2015年 Zhanglubao.com. All rights reserved.
//



#if (TARGET_OS_IPHONE || TARGET_IPHONE_SIMULATOR)

#pragma mark -

#undef	RGB
#define RGB(R,G,B)		[UIColor colorWithRed:R/255.0f green:G/255.0f blue:B/255.0f alpha:1.0f]

#undef	RGBA
#define RGBA(R,G,B,A)	[UIColor colorWithRed:R/255.0f green:G/255.0f blue:B/255.0f alpha:A]

#undef	HEX_RGB
#define HEX_RGB(V)		[UIColor fromHexValue:V]

#undef	HEX_RGBA
#define HEX_RGBA(V, A)	[UIColor fromHexValue:V alpha:A]

#undef	SHORT_RGB
#define SHORT_RGB(V)	[UIColor fromShortHexValue:V]

#undef	SRGB
#define SRGB(S)         [UIColor fromHexString:S]

#pragma mark -

@interface UIColor(ViewUtility)

+ (UIColor *)fromHexValue:(NSUInteger)hex;
+ (UIColor *)fromHexValue:(NSUInteger)hex alpha:(CGFloat)alpha;

+ (UIColor *)fromShortHexValue:(NSUInteger)hex;
+ (UIColor *)fromShortHexValue:(NSUInteger)hex alpha:(CGFloat)alpha;
+ (UIColor *) fromHexString: (NSString *)color;
+ (UIColor *) fromHexString:(NSString *)color alpha:(CGFloat)alpha;

@end

#endif	// #if (TARGET_OS_IPHONE || TARGET_IPHONE_SIMULATOR)
