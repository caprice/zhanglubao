package com.zhanglubao.lol.util;

import android.util.Log;

/**
 * Created by rocks on 15-6-25.
 */
public class Logger {
    public static int LOGLEVEL = 5;
    public static boolean VERBOSE = LOGLEVEL > 4;
    public static boolean DEBUG = Profile.LOG;
    public static boolean INFO = LOGLEVEL > 2;
    public static boolean WARN = LOGLEVEL > 1;
    public static boolean ERROR = Profile.LOG;

    public static void setDebugMode(boolean debugMode)
    {
        LOGLEVEL = debugMode ? 5 : 0;
        VERBOSE = LOGLEVEL > 4;
        DEBUG = LOGLEVEL > 3;
        INFO = LOGLEVEL > 2;
        WARN = LOGLEVEL > 1;
        ERROR = LOGLEVEL > 0;
    }

    public static void v(String tag, String msg)
    {
        if (DEBUG) {
            Log.v(tag, msg == null ? "" : msg);
        }
    }

    public static void v(String tag, String msg, Throwable tr)
    {
        if (DEBUG) {
            Log.v(tag, msg == null ? "" : msg, tr);
        }
    }

    public static void v(String msg)
    {
        if (DEBUG) {
            Log.v(Profile.TAG, msg == null ? "" : msg);
        }
    }

    public static void v(String msg, Throwable tr)
    {
        if (DEBUG) {
            Log.v(Profile.TAG, msg == null ? "" : msg, tr);
        }
    }

    public static void d(String tag, String msg)
    {
        if (DEBUG) {
            Log.d(tag, msg == null ? "" : msg);
        }
    }

    public static void d(String tag, String msg, Throwable tr)
    {
        if (DEBUG) {
            Log.d(tag, msg == null ? "" : msg, tr);
        }
    }

    public static void d(String msg)
    {
        if (DEBUG) {
            Log.d(Profile.TAG, msg == null ? "" : msg);
        }
    }

    public static void d(String msg, Throwable tr)
    {
        if (DEBUG) {
            Log.d(Profile.TAG, msg == null ? "" : msg, tr);
        }
    }

    public static void e(String tag, String msg)
    {
        if (ERROR) {
            Log.e(tag, msg == null ? "" : msg);
        }
    }

    public static void e(String tag, String msg, Throwable tr)
    {
        if (ERROR) {
            Log.e(tag, msg == null ? "" : msg, tr);
        }
    }

    public static void e(String msg)
    {
        if (ERROR) {
            Log.e(Profile.TAG, msg == null ? "" : msg);
        }
    }

    public static void e(String msg, Throwable tr)
    {
        if (ERROR) {
            Log.e(Profile.TAG, msg == null ? "" : msg, tr);
        }
    }
}