package com.zhanglubao.lol.downloader.util;

import android.app.Activity;
import android.content.SharedPreferences;

import com.zhanglubao.lol.config.ZLBConfiguration;

/**
 * Created by rocks on 15-6-12.
 */
public class PreferenceUtil {

    public static SharedPreferences getDownload() {
        return ZLBConfiguration.context.getSharedPreferences("download", Activity.MODE_PRIVATE);
    }
    public static void set(String name, String value) {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.putString(name, value);
        editor.commit();
    }

    public static String get(String name) {
        String result = getDownload().getString(name, "");
        return result;
    }

    public  static void remove(String key) {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.remove(key);
        editor.commit();
    }

    public static void setInt(String name, int value) {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.putInt(name, value);
        editor.commit();
    }

    public static int getInt(String name) {
        int result = getDownload().getInt(name, 0);
        return result;
    }

    public static void setBoolean(String name, boolean value) {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.putBoolean(name, value);
        editor.commit();
    }

    public static boolean getBoolean(String name) {
        boolean result = getDownload().getBoolean(name, false);
        return result;
    }

    public static String getPreference(String key)
    {

        return getDownload().getString(key, "");
    }

    public static void savePreference(String key, String value)
    {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.putString(key, value).commit();
    }

    public static void savePreference(String key, int value)
    {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.putInt(key, value).commit();
    }

    public static void savePreference(String key, Boolean value)
    {
        SharedPreferences.Editor editor = getDownload().edit();
        editor.putBoolean(key, value.booleanValue()).commit();
    }

    public static boolean getPreferenceBoolean(String key)
    {
        return getDownload().getBoolean(key, false);
    }

    public static String getPreference(String key, String def)
    {
        return getDownload().getString(key, def);
    }

    public static int getPreferenceInt(String key)
    {
        return getDownload().getInt(key, 0);
    }

    public static int getPreferenceInt(String key, int def)
    {
        return getDownload().getInt(key, def);
    }

    public static boolean getPreferenceBoolean(String key, boolean def)
    {
        return getDownload().getBoolean(key, def);
    }

}
