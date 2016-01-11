package com.zhanglubao.lol.util;


import android.app.ActivityManager;
import android.app.ActivityManager.RunningAppProcessInfo;
import android.content.ComponentName;
import android.content.Context;
import java.util.Iterator;
import java.util.List;

public class ApplicationUtil
{
	
	
 /***
  *获取top的Activity的ComponentName
  * @param paramContext
  * @return
  */
  public static ComponentName getTopActivityCompomentName(Context paramContext)
  {
    List<ActivityManager.RunningTaskInfo> localList = null;
    if (paramContext != null)
    {
      ActivityManager localActivityManager = (ActivityManager)paramContext.getSystemService("activity");
      if (localActivityManager != null)
      {
        localList = localActivityManager.getRunningTasks(1);
       
        if ((localList == null) || (localList.size() <= 0)){
        	return null;
        	}
      }
    }
    	ComponentName localComponentName = localList.get(0).topActivity;
      return localComponentName;
  }
	
  	/***
	 * 查看是否后台
	 * @param paramContext
	 * @return
	 */
  public static boolean isAppRunningBackground(Context paramContext)
  {
    String pkgName = null;
    List<RunningAppProcessInfo> localList = null;
    if (paramContext != null)
    {
      pkgName = paramContext.getPackageName();
      ActivityManager localActivityManager = (ActivityManager)paramContext.getSystemService("activity");
      if (localActivityManager != null)
      {
        localList = localActivityManager.getRunningAppProcesses();
        if ((localList == null) || (localList.size() <= 0)){
        	return false;
        }
      }
    } 
    
    for (Iterator<RunningAppProcessInfo> localIterator = localList.iterator(); localIterator.hasNext();) {
		RunningAppProcessInfo info = localIterator.next();
		if(info.processName.equals(pkgName)&&info.importance!=100){
			return true;						
		}
    }
    return false;
    }
}