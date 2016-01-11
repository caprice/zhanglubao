package com.zhanglubao.lol.util;

import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.content.res.Configuration;
import android.graphics.Color;
import android.os.Build;
import android.preference.PreferenceManager;
import android.text.Html;
import android.text.Spannable;
import android.text.SpannableStringBuilder;
import android.text.TextUtils;
import android.text.method.LinkMovementMethod;
import android.text.style.StyleSpan;
import android.view.WindowManager;
import android.widget.TextView;
import android.widget.Toast;

import java.util.Iterator;

/**
 * Created by rocks on 15-6-13.
 */
public class UIUtils {

    private static final int SECOND_MILLIS = 1000;
    private static final int MINUTE_MILLIS = 60000;
    private static final int HOUR_MILLIS = 3600000;
    private static final int DAY_MILLIS = 86400000;
    private static final int TIME_FLAGS = 32771;
    private static StyleSpan sBoldSpan = new StyleSpan(1);
    private static final int BRIGHTNESS_THRESHOLD = 130;
    private static final long sAppLoadTime = System.currentTimeMillis();
    private static int DEFAULT_ORIENTATION;

    public UIUtils() {
    }

    public static void setTextMaybeHtml(TextView view, String text) {
        if(TextUtils.isEmpty(text)) {
            view.setText("");
        } else {
            if(text.contains("<") && text.contains(">")) {
                view.setText(Html.fromHtml(text));
                view.setMovementMethod(LinkMovementMethod.getInstance());
            } else {
                view.setText(text);
            }

        }
    }

    public static Spannable buildStyledSnippet(String snippet) {
        SpannableStringBuilder builder = new SpannableStringBuilder(snippet);
        boolean startIndex = true;
        int endIndex = -1;

        int startIndex1;
        for(int delta = 0; (startIndex1 = snippet.indexOf(123, endIndex)) != -1; delta += 2) {
            endIndex = snippet.indexOf(125, startIndex1);
            builder.delete(startIndex1 - delta, startIndex1 - delta + 1);
            builder.delete(endIndex - delta - 1, endIndex - delta);
            builder.setSpan(sBoldSpan, startIndex1 - delta, endIndex - delta - 1, 33);
        }

        return builder;
    }

    public static void preferPackageForIntent(Context context, Intent intent, String packageName) {
        PackageManager pm = context.getPackageManager();
        Iterator var5 = pm.queryIntentActivities(intent, 0).iterator();

        while(var5.hasNext()) {
            ResolveInfo resolveInfo = (ResolveInfo)var5.next();
            if(resolveInfo.activityInfo.packageName.equals(packageName)) {
                intent.setPackage(packageName);
                break;
            }
        }

    }

    public static boolean isColorDark(int color) {
        return (30 * Color.red(color) + 59 * Color.green(color) + 11 * Color.blue(color)) / 100 <= 130;
    }

    public static boolean isNotificationFiredForBlock(Context context, String blockId) {
        SharedPreferences sp = PreferenceManager.getDefaultSharedPreferences(context);
        String key = String.format("notification_fired_%s", new Object[]{blockId});
        boolean fired = sp.getBoolean(key, false);
        sp.edit().putBoolean(key, true).commit();
        return fired;
    }

    public static long getCurrentTime(Context context) {
        return context.getSharedPreferences("mock_data", 0).getLong("mock_current_time", System.currentTimeMillis()) + System.currentTimeMillis() - sAppLoadTime;
    }

    public static void safeOpenLink(Context context, Intent linkIntent) {
        try {
            context.startActivity(linkIntent);
        } catch (ActivityNotFoundException var3) {
            Toast.makeText(context, "Couldn\'t open link", 0).show();
        }

    }

    public static boolean isGoogleTV(Context context) {
        return context.getPackageManager().hasSystemFeature("com.google.android.tv");
    }

    public static boolean hasFroyo() {
        return Build.VERSION.SDK_INT >= 8;
    }

    public static boolean hasGingerbread() {
        return Build.VERSION.SDK_INT >= 9;
    }

    public static boolean hasHoneycomb() {
        return Build.VERSION.SDK_INT >= 11;
    }

    public static boolean hasHoneycombMR1() {
        return Build.VERSION.SDK_INT >= 12;
    }

    public static boolean hasHoneycombMR2() {
        return Build.VERSION.SDK_INT >= 13;
    }

    public static boolean hasICS() {
        return Build.VERSION.SDK_INT >= 14;
    }

    public static boolean hasJellyBean() {
        return Build.VERSION.SDK_INT >= 16;
    }

    public static boolean hasKitKat() {
        return Build.VERSION.SDK_INT >= 19;
    }




    public static String getFormatTime(long millseconds) {
        long seconds = millseconds / 1000L;
        StringBuffer buf = new StringBuffer();
        long hour = seconds / 3600L;
        long min = seconds / 60L - hour * 60L;
        long sec = seconds - hour * 3600L - min * 60L;
        if(hour < 10L) {
            buf.append("0");
        }

        buf.append(hour).append(":");
        if(min < 10L) {
            buf.append("0");
        }

        buf.append(min).append(":");
        if(sec < 10L) {
            buf.append("0");
        }

        buf.append(sec);
        return buf.toString();
    }

    public static int getDeviceDefaultOrientation(Context context) {
        if(DEFAULT_ORIENTATION == 0) {
            WindowManager windowManager = (WindowManager)context.getSystemService("window");
            Configuration config = context.getResources().getConfiguration();
            int rotation = windowManager.getDefaultDisplay().getRotation();
            if((rotation != 0 && rotation != 2 || config.orientation != 2) && (rotation != 1 && rotation != 3 || config.orientation != 1)) {
                DEFAULT_ORIENTATION = 1;
            } else {
                DEFAULT_ORIENTATION = 2;
            }
        }

        return DEFAULT_ORIENTATION;
    }
}
