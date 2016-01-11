package com.zhanglubao.lol.util;

import android.content.SharedPreferences;

import com.zhanglubao.lol.ZLBApplication;

/**
 * Created by rocks on 15-6-24.
 */
public class DetailUtil {

    public static void writeLandScreen(int left, int top, int right, int bottom, int height, int width)
    {
        SharedPreferences sharedPreferences = ZLBApplication.mContext.getSharedPreferences("land_size", 0);
        if (sharedPreferences.getInt("height", 0) != 0) {
            return;
        }
        SharedPreferences.Editor localEditor = sharedPreferences.edit();
        localEditor.putInt("left", left);
        localEditor.putInt("top", top);
        localEditor.putInt("right", right);
        localEditor.putInt("bottom", bottom);
        localEditor.putInt("height", height);
        localEditor.putInt("width", width);
        localEditor.commit();
    }

    public static void writePortScreen(int left, int top, int right, int bottom, int height, int width)
    {
        SharedPreferences.Editor localEditor = ZLBApplication.mContext.getSharedPreferences("new_port_size", 0).edit();
        localEditor.putInt("left", left);
        localEditor.putInt("top", top);
        localEditor.putInt("right", right);
        localEditor.putInt("bottom", bottom);
        localEditor.putInt("height", height);
        localEditor.putInt("width", width);
        localEditor.commit();
    }

    public static int[] readLandScreen()
    {
        int[] array = new int[6];
        SharedPreferences sharedPreferences = ZLBApplication.mContext.getSharedPreferences("land_size", 0);
        array[0] = sharedPreferences.getInt("left", 0);
        array[1] = sharedPreferences.getInt("top", 0);
        array[2] = sharedPreferences.getInt("right", 0);
        array[3] = sharedPreferences.getInt("bottom", 0);
        array[4] = sharedPreferences.getInt("height", 0);
        array[5] = sharedPreferences.getInt("width", 0);
        return array;
    }

    public static int[] readPortScreen()
    {
        int[] array = new int[6];
        SharedPreferences sharedPreferences = ZLBApplication.mContext.getSharedPreferences("new_port_size", 0);
        array[0] = sharedPreferences.getInt("left", 0);
        array[1] = sharedPreferences.getInt("top", 0);
        array[2] = sharedPreferences.getInt("right", 0);
        array[3] = sharedPreferences.getInt("bottom", 0);
        array[4] = sharedPreferences.getInt("height", 0);
        array[5] = sharedPreferences.getInt("width", 0);
        return array;
    }
}
