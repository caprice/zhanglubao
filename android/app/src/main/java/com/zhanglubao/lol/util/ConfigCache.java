package com.zhanglubao.lol.util;

import android.util.Log;

import com.zhanglubao.lol.ZLBApplication;
import com.zhanglubao.lol.downloader.util.SDCardManager;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;


public class ConfigCache {
    private static final String TAG = ConfigCache.class.getName();

    public static final int CONFIG_CACHE_MOBILE_TIMEOUT = 3600000;  //1 hour
    public static final int CONFIG_CACHE_WIFI_TIMEOUT = 300000;   //5 minute
    public static String CACHE_PATH = "";
    /**
     * SD卡列表
     */
    public static ArrayList<SDCardManager.SDCardInfo> sdCard_list = SDCardManager.getExternalStorageDirectory();

    public static String getUrlCache(String url) {
        if (url == null) {
            return null;
        }
        if (sdCard_list == null) {
            return null;
        }
        if (CACHE_PATH == "") {
            CACHE_PATH = sdCard_list.get(0).path + "/zhanglubao/lol/netcache/";
        }
        String result = null;
        File file = new File(CACHE_PATH + getCacheDecodeString(url));
        if (file.exists() && file.isFile()) {
            long expiredTime = System.currentTimeMillis() - file.lastModified();
            Log.d(TAG, file.getAbsolutePath() + " expiredTime:" + expiredTime / 60000 + "min");
            //1. in case the system time is incorrect (the time is turn back long ago)
            //2. when the network is invalid, you can only read the cache
            if (!NetworkUtils.isNetworkAvailable() && expiredTime < 0) {
                return null;
            }
            if (NetworkUtils.isWifi(ZLBApplication.mContext)
                    && expiredTime > CONFIG_CACHE_WIFI_TIMEOUT) {
                return null;
            } else if (expiredTime > CONFIG_CACHE_MOBILE_TIMEOUT) {
                return null;
            }
            try {
                result = FileUtils.readTextFile(file);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        return result;
    }

    public static void setUrlCache(String data, String url) {
        if (CACHE_PATH == "") {
            CACHE_PATH = sdCard_list.get(0).path + "/zhanglubao/lol/netcache/";
        }
        File f = new File(CACHE_PATH);
        if (!f.exists()) {
            f.mkdirs();
        }
        f = new File(CACHE_PATH + getCacheDecodeString(url));
        if (f.exists() && f.isFile()) {
            f.delete();
        }

        try {
            f.createNewFile();
            FileUtils.writeTextFile(f, data);
        } catch (IOException e) {
            Log.d(TAG, "write " + f.getAbsolutePath() + " data failed!");
            e.printStackTrace();
        }
    }

    public static String getCacheDecodeString(String url) {
        //1. 处理特殊字符
        //2. 去除后缀名带来的文件浏览器的视图凌乱(特别是图片更需要如此类似处理，否则有的手机打开图库，全是我们的缓存图片)
        if (url != null) {
            try {
                return MD5.encryptMD5(url);
            } catch (Exception e) {
                return null;
            }
        }
        return null;
    }
}