package com.zhanglubao.lol.downloader.util;

import android.text.TextUtils;

import com.zhanglubao.lol.config.ZLBConfiguration;
import com.zhanglubao.lol.util.Logger;

/**
 * Created by rocks on 15-6-27.
 */
public class ConfigUtil {

    private static String TAG=ConfigUtil.class.getName();
    public static final int FORMAT_NORMAL = 1;
    public static final int FORMAT_HIGHT = 2;
    public static final int FORMAT_HD = 3;
    public static final int FORMAT_ORGINAL = 4;
    public static final int TIMEOUT = 30000;


    public static  String DISK_PATH="zhanglubao/lol/disk/";
    public static  String OFFLINE_PATH="zhanglubao/lol/offlinedata/";
    private static  String DOWNLOAD_PATH="zhanglubao/lol/download/";

    public static String getDownloadPath()
    {
        if (!TextUtils.isEmpty(DOWNLOAD_PATH))
        {
            if (!DOWNLOAD_PATH.startsWith("/")) {
                DOWNLOAD_PATH = "/" + DOWNLOAD_PATH;
            }
            if (!DOWNLOAD_PATH.endsWith("/")) {
                DOWNLOAD_PATH += "/";
            }
        }
        else
        {
            String pkg = ZLBConfiguration.context.getPackageName();
            DOWNLOAD_PATH = "/" + pkg + "/videocache/";
        }
        Logger.d(TAG, "download_path: " + DOWNLOAD_PATH);

        return DOWNLOAD_PATH;
    }
}
