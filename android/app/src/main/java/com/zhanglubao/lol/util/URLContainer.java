package com.zhanglubao.lol.util;

import com.zhanglubao.lol.network.QTUrl;

import java.io.UnsupportedEncodingException;


public class URLContainer {
    /**  本地时间与服务器时间戳 单位 秒	 */
    public static long TIMESTAMP = 0;
    public static void init() {

    }
    public static String getVideoDownloadDetailUrl(String videoid)
    {

        String u = QTUrl.sniff_video_download+"&id="+videoid;
        Logger.d("Download_getVideoDownloadDetailUrl()", u);
        return u;
    }
    public static String getDownloadURL(String vid)
    {
        String u = QTUrl.sniff_video_download+"&id="+vid;
        Logger.d("Download_getDownloadURL()", u);
        return u;
    }

    private static String URLEncoder(String s) {
        if (s == null || s.length() == 0)
            return "";
        try {
            s = java.net.URLEncoder.encode(s, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            return "";
        } catch (NullPointerException e) {
            return "";
        }
        return s;
    }


}