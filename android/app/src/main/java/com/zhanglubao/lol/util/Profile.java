package com.zhanglubao.lol.util;

import android.content.Context;

/**
 * Created by rocks on 15-6-29.
 */
public class Profile {

    public static Context mContext;
    public static final int TIMEOUT = 30000;
    public static String TAG;
    public static String User_Agent;

    public static void initProfile(String tag, String useragent, Context context)
    {
        TAG = tag;
        User_Agent = useragent;
        mContext = context;
    }

    public static void initProfile(int from, String tag, String useragent, Context context)
    {
        initProfile(tag, useragent, context);
        FROM = from;
    }


    public static String COOKIE = null;
    public static boolean isLogined;
    public static int FROM;
    public static boolean DEBUG = false;
    public static boolean LOG = false;

}
