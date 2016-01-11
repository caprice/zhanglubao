package com.zhanglubao.lol.util;

import android.content.SharedPreferences;

import com.zhanglubao.lol.ZLBApplication;

/**
 * Created by rocks on 15-6-12.
 */
public class PreferenceUtil {

    public static void set(String name, String value) {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.putString(name, value);
        editor.commit();
    }

    public static String get(String name) {
        String result = ZLBApplication.mPref.getString(name, "");
        return result;
    }

    public  static void remove(String key) {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.remove(key);
        editor.commit();
    }

    public static void setInt(String name, int value) {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.putInt(name, value);
        editor.commit();
    }

    public static int getInt(String name) {
        int result = ZLBApplication.mPref.getInt(name, 0);
        return result;
    }

    public static void setBoolean(String name, boolean value) {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.putBoolean(name, value);
        editor.commit();
    }

    public static boolean getBoolean(String name) {
        boolean result = ZLBApplication.mPref.getBoolean(name,false);
        return result;
    }

    public static String getPreference(String key)
    {

        return ZLBApplication.mPref.getString(key, "");
    }

    public static void savePreference(String key, String value)
    {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.putString(key, value).commit();
    }

    public static void savePreference(String key, int value)
    {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.putInt(key, value).commit();
    }

    public static void savePreference(String key, Boolean value)
    {
        SharedPreferences.Editor editor = ZLBApplication.mPref.edit();
        editor.putBoolean(key, value.booleanValue()).commit();
    }

    public static boolean getPreferenceBoolean(String key)
    {
        return ZLBApplication.mPref.getBoolean(key, false);
    }

    public static String getPreference(String key, String def)
    {
        return ZLBApplication.mPref.getString(key, def);
    }

    public static int getPreferenceInt(String key)
    {
        return ZLBApplication.mPref.getInt(key, 0);
    }

    public static int getPreferenceInt(String key, int def)
    {
        return ZLBApplication.mPref.getInt(key, def);
    }

    public static boolean getPreferenceBoolean(String key, boolean def)
    {
        return ZLBApplication.mPref.getBoolean(key, def);
    }

}
