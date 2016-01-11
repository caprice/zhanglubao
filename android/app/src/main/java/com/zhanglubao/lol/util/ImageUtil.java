package com.zhanglubao.lol.util;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.ColorMatrix;
import android.graphics.ColorMatrixColorFilter;
import android.graphics.LinearGradient;
import android.graphics.Matrix;
import android.graphics.Paint;
import android.graphics.PixelFormat;
import android.graphics.PorterDuff.Mode;
import android.graphics.PorterDuffXfermode;
import android.graphics.Rect;
import android.graphics.RectF;
import android.graphics.Shader.TileMode;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.InputStream;


public class ImageUtil {

	

	

	/**
	 * 从sd卡读取图片
	 * 
	 * @param path
	 * @return
	 */
	public static Bitmap readBitMap(String path) {
		BitmapFactory.Options options = new BitmapFactory.Options();
		options.inPreferredConfig = Config.ARGB_8888;
		Bitmap bm = BitmapFactory.decodeFile(path, options);
		return bm;
	}
	
	/**
	 * 图片旋转
	 * 
	 * @param bmp
	 * @param degree
	 * @return
	 */
	public static Bitmap postRotateBitamp(Bitmap bmp, float degree) {
		// 获得Bitmap的高和宽
		int bmpWidth = bmp.getWidth();
		int bmpHeight = bmp.getHeight();
		// 产生resize后的Bitmap对象
		Matrix matrix = new Matrix();
		matrix.postRotate(degree);
		Bitmap resizeBmp = Bitmap.createBitmap(bmp, 0, 0, bmpWidth, bmpHeight, matrix, true);
		return resizeBmp;
	}

	/**
	 *  图片翻转
	 * @param bmp
	 * @param flag
	 * @return
	 */
	public static Bitmap reverseBitmap(Bitmap bmp, int flag) {
		float[] floats = null;
		switch (flag) {
		case 0: // 水平反转
			floats = new float[] { -1f, 0f, 0f, 0f, 1f, 0f, 0f, 0f, 1f };
			break;
		case 1: // 垂直反转
			floats = new float[] { 1f, 0f, 0f, 0f, -1f, 0f, 0f, 0f, 1f };
			break;
		}

		if (floats != null) {
			Matrix matrix = new Matrix();
			matrix.setValues(floats);
			return Bitmap.createBitmap(bmp, 0, 0, bmp.getWidth(), bmp.getHeight(), matrix, true);
		}

		return bmp;
	}
	
	
	

	
	/**
	 * 图片转换 字节转drawable
	 * @param byteArray
	 * @return
	 */
	public static Drawable byteToDrawable(byte[] byteArray){
		ByteArrayInputStream ins = new ByteArrayInputStream(byteArray);
		return Drawable.createFromStream(ins, null);
	}
	/**
	 * 图片转换 图片转字节
	 * @param bm
	 * @return
	 */
	public static byte[] Bitmap2Bytes(Bitmap bm){ 
		ByteArrayOutputStream baos = new ByteArrayOutputStream();
		bm.compress(Bitmap.CompressFormat.PNG, 100, baos);
		return baos.toByteArray();
	}
	
	/**
	 * drawable 转bitmap
	 * @param drawable
	 * @return
	 */
	public static Bitmap drawableToBitmap(Drawable drawable) {
		Bitmap bitmap = Bitmap
				.createBitmap(
						drawable.getIntrinsicWidth(),
						drawable.getIntrinsicHeight(),
						drawable.getOpacity() != PixelFormat.OPAQUE ? Config.ARGB_8888
								: Config.RGB_565);
		Canvas canvas = new Canvas(bitmap);
		drawable.setBounds(0, 0, drawable.getIntrinsicWidth(),
				drawable.getIntrinsicHeight());
		drawable.draw(canvas);
		return bitmap;
	}
	// 放大缩小图片
	public static Bitmap zoomBitmap(Bitmap bitmap, int w, int h) {
		int width = bitmap.getWidth();
		int height = bitmap.getHeight();
		Matrix matrix = new Matrix();
		float scaleWidht = ((float) w / width);
		float scaleHeight = ((float) h / height);
		matrix.postScale(scaleWidht, scaleHeight);
		Bitmap newbmp = Bitmap.createBitmap(bitmap, 0, 0, width, height, matrix, true);
		return newbmp;
	}
		/**
		 * 获取获得带倒影的图片
		 * @param bitmap
		 * @return
		 */
		public static Bitmap createReflectionImageWithOrigin(Bitmap bitmap) {
			final int reflectionGap = 4;
			int width = bitmap.getWidth();
			int height = bitmap.getHeight();
			Matrix matrix = new Matrix();
			matrix.preScale(1, -1);
			Bitmap bitmapWithReflection = Bitmap.createBitmap(width, (height + height / 2), Config.ARGB_8888);
			Canvas canvas = new Canvas(bitmapWithReflection);
			canvas.drawBitmap(bitmap, 0, 0, null);
			Paint deafalutPaint = new Paint();
			canvas.drawRect(0, height, width, height + reflectionGap, deafalutPaint);

			Paint paint = new Paint();
			LinearGradient shader = new LinearGradient(0, bitmap.getHeight(), 0, bitmapWithReflection.getHeight()
					+ reflectionGap, 0x70ffffff, 0x00ffffff, TileMode.CLAMP);
			paint.setShader(shader);
			// Set the Transfer mode to be porter duff and destination in
			paint.setXfermode(new PorterDuffXfermode(Mode.DST_IN));
			// Draw a rectangle using the paint with our linear gradient
			canvas.drawRect(0, height, width, bitmapWithReflection.getHeight() + reflectionGap, paint);

			return bitmapWithReflection;
		}
	 	/**
	     * 图片去色,返回灰度图片
	     * @param bmpOriginal 传入的图片
	     * @return 去色后的图片
	     */
	    public static Bitmap toGrayscale(Bitmap bmpOriginal) {
	        int width, height;
	        height = bmpOriginal.getHeight();
	        width = bmpOriginal.getWidth();    
	        Bitmap bmpGrayscale = Bitmap.createBitmap(width, height, Config.RGB_565);
	        Canvas c = new Canvas(bmpGrayscale);
	        Paint paint = new Paint();
	        ColorMatrix cm = new ColorMatrix();
	        cm.setSaturation(0);
	        ColorMatrixColorFilter f = new ColorMatrixColorFilter(cm);
	        paint.setColorFilter(f);
	        c.drawBitmap(bmpOriginal, 0, 0, paint);
	        return bmpGrayscale;
	    }
	    
	    
	    
	  
	    
	    /**
	     * 把图片变成圆角
	     * @param bitmap 需要修改的图片
	     * @param pixels 圆角的弧度
	     * @return 圆角图片
	     */
	    public static Bitmap toRoundCorner(Bitmap bitmap, int pixels){
	        Bitmap output = Bitmap.createBitmap(bitmap.getWidth(), bitmap.getHeight(), Config.ARGB_8888);
	        Canvas canvas = new Canvas(output);
	        final int color = 0xff424242;
	        final Paint paint = new Paint();
	        final Rect rect = new Rect(0, 0, bitmap.getWidth(), bitmap.getHeight());
	        final RectF rectF = new RectF(rect);
	        final float roundPx = pixels;
	        paint.setAntiAlias(true);
	        canvas.drawARGB(0, 0, 0, 0);
	        paint.setColor(color);
	        canvas.drawRoundRect(rectF, roundPx, roundPx, paint);
	        paint.setXfermode(new PorterDuffXfermode(Mode.SRC_IN));
	        canvas.drawBitmap(bitmap, rect, rect, paint);
	        return output;
	    }
	
	    
	   /**
	     * 使圆角功能支持BitampDrawable
	     * @param bitmapDrawable 
	     * @param pixels 
	     * @return
	     */
	    public static BitmapDrawable toRoundCorner(BitmapDrawable bitmapDrawable, int pixels) {
	        Bitmap bitmap = bitmapDrawable.getBitmap();
	        bitmapDrawable = new BitmapDrawable(toRoundCorner(bitmap, pixels));
	        return bitmapDrawable;
	    }
	    
	
	    public static Bitmap makeReflectionBitmap(Bitmap originalImage){
	    	  final int reflectionGap = 4;
	          int width = originalImage.getWidth();
	          int height = originalImage.getHeight();
	          // 实现图片的反转
	          Matrix matrix = new Matrix();
	          matrix.preScale(1, -1);
	          matrix.postRotate(360f);
	          
	          // 创建反转后的图片Bitmap对象，图片高是原图的一半。
	          Bitmap reflectionImage = Bitmap.createBitmap(originalImage, 0,
	                  height/2, width, height/2, matrix, false);
	          // 创建标准的Bitmap对象，宽和原图一致，高是原图的1.5倍。
	          
	          Bitmap bitmapWithReflection = Bitmap.createBitmap(width,
	                  (height + height/2), Config.ARGB_8888);
	          // 创建画布对象，将原图画于画布，起点是原点位置。
	          Canvas canvas = new Canvas(bitmapWithReflection);
	          canvas.drawBitmap(originalImage, 0, 0, null);//(originalImage, matrix, new Paint());
	          //将反转后的图片画到画布中。
	          Paint defaultPaint=new Paint();
	          canvas.drawRect(0, height,width,height+reflectionGap,defaultPaint);
	          canvas.drawBitmap(reflectionImage, 0 , height+reflectionGap, null);
	          Paint paint=new Paint();
	          //创建线性渐变LinearGradient 对象。
	          LinearGradient shader=new LinearGradient(0, originalImage.getHeight(), 0, bitmapWithReflection.getHeight()+reflectionGap,0X70ffffff,0X00ffffff,TileMode.MIRROR);
	          paint.setShader(shader);
	          paint.setXfermode(new PorterDuffXfermode(Mode.DST_IN));
	          canvas.drawRect(0,height,width,bitmapWithReflection.getHeight()+reflectionGap, paint);
	          return bitmapWithReflection;
	    	     }
	    public static Bitmap readBitMap(Context context, int resId){  
	        BitmapFactory.Options options = new BitmapFactory.Options();  
	        options.inPreferredConfig = Config.RGB_565;
	        options.inPurgeable = true;  
	        options.inInputShareable = true;  
	   	try {
			// 4. inNativeAlloc 属性设置为true，可以不把使用的内存算到VM里
			BitmapFactory.Options.class.getField("inNativeAlloc")
					.setBoolean(options, true);
		} catch (Exception e) {
			e.printStackTrace();
		}
	          //获取资源图片  
	       InputStream is = context.getResources().openRawResource(resId);  
	           return BitmapFactory.decodeStream(is,null,options);  
	    }
}
