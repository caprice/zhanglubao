package com.zhanglubao.lol.util;

import android.content.Context;

public class QTUtil {
	
	public static int dip2px(Context context,float dipValue){
		float scale=context.getResources().getDisplayMetrics().density;		
		return (int) (scale*dipValue+0.5f);		
	}
	
	public static int px2dip(Context context,float pxValue){
		float scale=context.getResources().getDisplayMetrics().density;		
		return (int) (pxValue/scale+0.5f);
	}

	
	public static String delHtml(String str)
	{
		String info = str.replaceAll("\\&[a-zA-Z]{1,10};", "").replaceAll("<[^>]*>", "");  
		info = info.replaceAll("[(/>)<]", ""); 
		return info;
	}
	
}
