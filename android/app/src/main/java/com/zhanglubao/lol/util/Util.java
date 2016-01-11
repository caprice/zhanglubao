package com.zhanglubao.lol.util;

import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Looper;
import android.os.Message;
import android.os.StatFs;
import android.text.TextUtils;
import android.widget.Toast;

import com.zhanglubao.lol.ZLBApplication;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * Created by rocks on 15-6-24.
 */
public final class Util {

    public static final int CHINESE = 0;
    public static final int NUMBER_OR_CHARACTER = 1;
    public static final int NUMBER_CHARACTER = 2;
    public static final int MIX = 3;
    public static final int EXCEPTION = -1;
    private static final String LINE_SEPARATOR = System.getProperty("line.separator");
    private static final float scale;
    private static final float scaledDensity;
    private long previousToastShow;
    private String previousToastString = "";
    public static long LAST_EXIT_INTENT_TIME;
    public static String SECRET;
    public static Long TIME_STAMP;
    static char[] hexDigits;
    private static int retry_count;

    static {
        scale = Profile.mContext.getResources().getDisplayMetrics().density;
        scaledDensity = Profile.mContext.getResources().getDisplayMetrics().scaledDensity;
        hexDigits = new char[]{'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'};
    }

    private Util() {
    }

    public static String getBundleValue(Bundle bundle, String label, String Default, boolean throwException) {
        String value = null;

        try {
            value = bundle.getString(label);
        } catch (Exception var6) {
            if(throwException) {
                Logger.e("F.getBundleValue()", var6);
            } else {
                Logger.e("throw Exception:  get String Bundle label " + label + " is null");
            }
        }

        return TextUtils.isEmpty(value)?Default:value;
    }

    public static String formatTime(long time) {
        String minute = "" + time / 60L;
        String second = "" + time % 60L;
        if(minute.length() == 1) {
            minute = "0" + minute;
        }

        if(second.length() == 1) {
            second = "0" + second;
        }

        return minute + "分" + second + "秒";
    }

    public static String formatTime(double s) {
        try {
            long e = (long)s;
            String seconds = "00" + e % 60L;
            String minutes = "" + e / 60L;
            if(minutes.length() == 1) {
                minutes = "0" + minutes;
            }

            seconds = seconds.substring(seconds.length() - 2, seconds.length());
            String times = minutes + ":" + seconds;
            return times;
        } catch (Exception var7) {
            Logger.e("ERROR formatTime() e=" + var7.toString());
            return "";
        }
    }

    public static String URLEncoder(String s) {
        if(s != null && s.trim().length() != 0) {
            try {
                s = URLEncoder.encode(s, "UTF-8");
                return s;
            } catch (UnsupportedEncodingException var2) {
                return "";
            } catch (NullPointerException var3) {
                return "";
            }
        } else {
            return "";
        }
    }

    public static boolean isMD5(String s) {
        return s != null && s.length() == 32;
    }

    public static String md5(String s) {
        try {
            MessageDigest e = MessageDigest.getInstance("MD5");
            e.update(s.getBytes());
            byte[] messageDigest = e.digest();
            StringBuffer hexString = new StringBuffer();

            for(int i = 0; i < messageDigest.length; ++i) {
                String h;
                for(h = Integer.toHexString(255 & messageDigest[i]); h.length() < 2; h = "0" + h) {
                    ;
                }

                hexString.append(h);
            }

            return hexString.toString();
        } catch (NoSuchAlgorithmException var6) {
            Logger.e("Util.md5()", var6);
            return "";
        }
    }

    public static String getPosterImgUrlTrait(String imgUrl) {
        String s;
        try {
            s = URLEncoder.encode(imgUrl.replace("*", ""), "UTF-8");
        } catch (UnsupportedEncodingException var3) {
            Logger.e("Util#getPosterImgUrlTrait()", var3);
            s = "";
        }

        return s;
    }

    public static String convertStreamToString(InputStream is) {
        BufferedReader reader = new BufferedReader(new InputStreamReader(is));
        StringBuilder sb = new StringBuilder();
        String line = null;

        try {
            while((line = reader.readLine()) != null) {
                sb.append(line);
                sb.append(LINE_SEPARATOR);
            }
        } catch (IOException var13) {
            ;
        } finally {
            try {
                is.close();
            } catch (IOException var12) {
                ;
            }

        }

        return sb.toString();
    }

    public static void deleteFile(File file) {
        if(file != null) {
            if(file.exists()) {
                if(file.isFile()) {
                    file.delete();
                    return;
                }

                if(file.isDirectory()) {
                    File[] files = file.listFiles();
                    if(files != null) {
                        for(int i = 0; i < files.length; ++i) {
                            deleteFile(files[i]);
                        }
                    }
                }

                file.delete();
            }

        }
    }

    public static boolean hasInternet() {
        ConnectivityManager m = (ConnectivityManager)Profile.mContext.getSystemService("connectivity");
        if(m == null) {
            Logger.d("NetWorkState", "Unavailabel");

            return false;
        } else {
            NetworkInfo[] info = m.getAllNetworkInfo();
            if(info != null) {
                for(int i = 0; i < info.length; ++i) {
                    if(info[i].getState() == NetworkInfo.State.CONNECTED) {
                        Logger.d("NetWorkState", "Availabel");

                        return true;
                    }
                }
            }

            return false;
        }
    }

    public static boolean isWifi() {
        ConnectivityManager m = (ConnectivityManager)Profile.mContext.getSystemService("connectivity");
        NetworkInfo n = m.getActiveNetworkInfo();
        return n != null && n.getType() == 1;
    }

    public static int getNetworkType() {
        ConnectivityManager m = (ConnectivityManager)Profile.mContext.getSystemService("connectivity");
        NetworkInfo info = m.getActiveNetworkInfo();
        if(info != null) {
            if(info.getType() == 1) {
                return 1000;
            }

            if(info.getType() == 0) {
                switch(info.getSubtype()) {
                    case 1:
                        return 1;
                    case 2:
                        return 2;
                    case 3:
                        return 3;
                    case 4:
                        return 4;
                    case 5:
                        return 5;
                    case 6:
                        return 6;
                    case 7:
                        return 7;
                    case 8:
                        return 8;
                    case 9:
                        return 9;
                    case 10:
                        return 10;
                    case 11:
                        return 11;
                    case 12:
                        return 12;
                    case 13:
                        return 13;
                    case 14:
                        return 14;
                    case 15:
                        return 15;
                }
            }
        }

        return 0;
    }

    public static boolean checkVerificationCode(String line, int length) {
        if(line.contains(" ")) {
            return false;
        } else {
            Pattern p = Pattern.compile("[^0-9a-zA-Z]+");
            Matcher m = p.matcher(line);
            return !m.find() && line.length() == length;
        }
    }

    public static boolean hasSDCard() {
        return "mounted".equals(Environment.getExternalStorageState());
    }

    public static String join(Object... objs) {
        if(objs == null) {
            return null;
        } else {
            StringBuffer result = new StringBuffer();
            int i = 0;
            Object[] var6 = objs;
            int var5 = objs.length;

            for(int var4 = 0; var4 < var5; ++var4) {
                Object obj = var6[var4];
                result.append("" + obj);
                if(i != objs.length - 1) {
                    result.append(",");
                }

                ++i;
            }

            return result.toString();
        }
    }

    public static String join(int[] numbers) {
        String result = "";
        int i = 0;
        int[] var6 = numbers;
        int var5 = numbers.length;

        for(int var4 = 0; var4 < var5; ++var4) {
            int num = var6[var4];
            result = result + num;
            if(i != numbers.length - 1) {
                result = result + ",";
            }

            ++i;
        }

        return result;
    }

    public static String join(long[] numbers) {
        String result = "";
        int i = 0;
        long[] var7 = numbers;
        int var6 = numbers.length;

        for(int var5 = 0; var5 < var6; ++var5) {
            long num = var7[var5];
            result = result + num;
            if(i != numbers.length - 1) {
                result = result + ",";
            }

            ++i;
        }

        return result;
    }

    public static int[] string2int(String[] numbers) {
        int[] nums = new int[numbers.length];
        int i = 0;

        try {
            String[] var6 = numbers;
            int var5 = numbers.length;

            for(int var4 = 0; var4 < var5; ++var4) {
                String e = var6[var4];
                nums[i] = Integer.parseInt(e);
                ++i;
            }

            return nums;
        } catch (NumberFormatException var7) {
            return nums;
        }
    }

    public static long[] string2long(String[] numbers) {
        long[] nums = new long[numbers.length];
        int i = 0;

        try {
            String[] var6 = numbers;
            int var5 = numbers.length;

            for(int var4 = 0; var4 < var5; ++var4) {
                String e = var6[var4];
                nums[i] = Long.parseLong(e);
                ++i;
            }

            return nums;
        } catch (NumberFormatException var7) {
            return nums;
        }
    }

    public static int dip2px(float dipValue) {
        return (int)(dipValue * scale + 0.5F);
    }

    public static int px2dip(float pxValue) {
        return (int)(pxValue / scale + 0.5F);
    }

    public static float sp2px(float spValue, int type) {
        switch(type) {
            case 0:
                return spValue * scaledDensity;
            case 1:
                return spValue * scaledDensity * 10.0F / 18.0F;
            default:
                return spValue * scaledDensity;
        }
    }

    public static boolean isNumber(String str) {
        return str.matches("[\\d]+[.]?[\\d]+");
    }

    public static int judgeStringType(String input) {
        String chineseRegex = "^[一-龥]*$";
        String character = "^[A-Za-z]+$";
        String numberRegex = "^[0-9]+$";
        String numberAndChar = "[0-9]+[A-Za-z]+";
        String numberAndChineseRegex = "[0-9]+[一-龥]+";
        String charAndChineseRegex = "[A-Za-z]+[一-龥]+";
        String all = "[0-9]+[一-龥]+[A-Za-z]+";
        return input.matches(chineseRegex)?0:(input.matches(charAndChineseRegex)?2:(input.matches(character)?1:(input.matches(numberRegex)?1:(input.matches(numberAndChineseRegex)?2:(input.matches(all)?3:(input.matches(numberAndChar)?1:0))))));
    }

    public static int numbersCount(String input) {
        String numberRegex = "[0-9]";
        int count = 0;

        for(int i = 0; i < input.length(); ++i) {
            if(String.valueOf(input.charAt(i)).matches(numberRegex)) {
                ++count;
            }
        }

        return count;
    }

    public static int ChineseCount(String input) {
        String chineseRegex = "[一-龥]";
        int count = 0;

        for(int i = 0; i < input.length(); ++i) {
            if(String.valueOf(input.charAt(i)).matches(chineseRegex)) {
                ++count;
            }
        }

        return count;
    }

    public static Boolean isLandscape(Context c) {
        return c.getResources().getConfiguration().orientation == 2?Boolean.valueOf(true):Boolean.valueOf(false);
    }

    public static void goBrowser(Context context, String url) {
        Intent i = new Intent("android.intent.action.VIEW");
        i.setData(Uri.parse(url));
        context.startActivity(i);
    }

    public static String formatSize(float size) {
        long kb = 1024L;
        long mb = kb * 1024L;
        long gb = mb * 1024L;
        return size < (float)kb?String.format("%dB", new Object[]{Integer.valueOf((int)size)}):(size < (float)mb?String.format("%.1fK", new Object[]{Float.valueOf(size / (float)kb)}):(size < (float)gb?String.format("%.1fM", new Object[]{Float.valueOf(size / (float)mb)}):String.format("%.1fG", new Object[]{Float.valueOf(size / (float)gb)})));
    }

    public static long[] getSDCardInfo() {
        if("mounted".equals(Environment.getExternalStorageState())) {
            long[] sdCardInfo = new long[2];
            File sdcardDir = Environment.getExternalStorageDirectory();
            StatFs sf = new StatFs(sdcardDir.getAbsolutePath());
            long bSize = (long)sf.getBlockSize();
            long bCount = (long)sf.getBlockCount();
            long availBlocks = (long)sf.getAvailableBlocks();
            sdCardInfo[0] = bSize * bCount;
            sdCardInfo[1] = bSize * availBlocks;
            return sdCardInfo;
        } else {
            return null;
        }
    }

    public static long getSdcardZlbSpace() {
        File file = new File(Environment.getExternalStorageDirectory().getAbsolutePath() + "/zhanglubao");
        if(!file.exists()) {
            file.mkdirs();
        }

        return getFileSize(file);
    }

    public static long getSdcardOtherSpace() {
        StatFs statFs = new StatFs(Environment.getExternalStorageDirectory().getAbsolutePath());
        long nTotalBlocks = (long)statFs.getBlockCount();
        long nAvailaBlock = (long)statFs.getAvailableBlocks();
        long nBlocSize = (long)statFs.getBlockSize();
        long nSDTotalSize = nTotalBlocks * nBlocSize;
        long nSDFreeSize = nAvailaBlock * nBlocSize;
        return nSDTotalSize - nSDFreeSize - getSdcardZlbSpace();
    }

    public static int getZlbProgrss() {
        StatFs statFs = new StatFs(Environment.getExternalStorageDirectory().getAbsolutePath());
        long nTotalBlocks = (long)statFs.getBlockCount();
        long nBlocSize = (long)statFs.getBlockSize();
        long nSDTotalSize = nTotalBlocks * nBlocSize;
        return nSDTotalSize == 0L?0:(int)(100L * getSdcardZlbSpace() / nSDTotalSize);
    }

    public static int getOtherProgrss() {
        StatFs statFs = new StatFs(Environment.getExternalStorageDirectory().getAbsolutePath());
        long nTotalBlocks = (long)statFs.getBlockCount();
        long nAvailaBlock = (long)statFs.getAvailableBlocks();
        long nBlocSize = (long)statFs.getBlockSize();
        long nSDTotalSize = nTotalBlocks * nBlocSize;
        if(nSDTotalSize == 0L) {
            return 0;
        } else {
            long nSDFreeSize = nAvailaBlock * nBlocSize;
            long size = nSDTotalSize - nSDFreeSize - getSdcardZlbSpace();
            return (int)(100L * size / nSDTotalSize);
        }
    }

    private static long getFileSize(File f) {
        long size = 0L;
        if(f.isDirectory()) {
            File[] flist = f.listFiles();

            for(int i = 0; i < flist.length; ++i) {
                if(flist[i].isDirectory()) {
                    size += getFileSize(flist[i]);
                } else {
                    size += flist[i].length();
                }
            }
        } else {
            size += f.length();
        }

        return size;
    }

    public static final boolean isConfirmedExit() {
        long currentTime = System.currentTimeMillis();
        if(currentTime - LAST_EXIT_INTENT_TIME < 3000L) {
            return true;
        } else {
            LAST_EXIT_INTENT_TIME = currentTime;
            return false;
        }
    }

    public static final int clearCacheFolder(File dir) {
        int deletedFiles = 0;
        if(dir != null && dir.isDirectory()) {
            try {
                File[] var5;
                int var4 = (var5 = dir.listFiles()).length;

                for(int var3 = 0; var3 < var4; ++var3) {
                    File e = var5[var3];
                    if(e.isDirectory()) {
                        deletedFiles += clearCacheFolder(e);
                    }

                    if(e.delete()) {
                        ++deletedFiles;
                    }
                }
            } catch (Exception var6) {
                Logger.e("Util#clearCacheFolder()", var6);
            }
        }

        return deletedFiles;
    }

    public static void clearCache(Context context) {
        clearCacheFolder(context.getCacheDir());
        if(Environment.getExternalStorageState().equals("mounted")) {
            clearCacheFolder(context.getExternalCacheDir());
        }

    }

    public static String getMD5Str(String str) {
        MessageDigest messageDigest = null;

        try {
            messageDigest = MessageDigest.getInstance("MD5");
            messageDigest.reset();
            messageDigest.update(str.getBytes("UTF-8"));
        } catch (NoSuchAlgorithmException var5) {
            Logger.e("F.getMD5Str()", var5);
        } catch (UnsupportedEncodingException var6) {
            Logger.e("F.getMD5Str()", var6);
        }

        byte[] byteArray = messageDigest.digest();
        StringBuffer md5StrBuff = new StringBuffer();

        for(int i = 0; i < byteArray.length; ++i) {
            if(Integer.toHexString(255 & byteArray[i]).length() == 1) {
                md5StrBuff.append("0").append(Integer.toHexString(255 & byteArray[i]));
            } else {
                md5StrBuff.append(Integer.toHexString(255 & byteArray[i]));
            }
        }

        return md5StrBuff.substring(8, 24).toString().toUpperCase();
    }

    public static String getTime() {
        SimpleDateFormat sDateFormat = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss");
        String date = sDateFormat.format(new Date());
        date = date.replace("-", "");
        date = date.replace("-", "");
        date = date.replace(":", "");
        date = date.replace(":", "");
        date = date.replace(" ", "");
        date = date.substring(2);
        date = date + "000";
        return date;
    }

    public static boolean isFinalUrl(String url) {
        if(TextUtils.isEmpty(url)) {
            return false;
        } else {
            url = url.toLowerCase().trim();
            return url.endsWith(".3gp") || url.endsWith(".mp4") || url.endsWith(".3gphd") || url.endsWith(".flv") || url.endsWith(".3gp") || url.endsWith(".m3u8");
        }
    }

    public static int getSecond(String T) {
        if(-1 == T.indexOf(":")) {
            return Integer.parseInt("T");
        } else {
            String time = new String(T);
            time = ":::" + time;
            int lastIndex = time.lastIndexOf(":");
            String StrSecond = time.substring(lastIndex + 1);
            time = time.substring(0, lastIndex);
            lastIndex = time.lastIndexOf(":");
            String StrMinutes = time.substring(lastIndex + 1);
            time = time.substring(0, lastIndex);
            lastIndex = time.lastIndexOf(":");
            String StrHours = time.substring(lastIndex + 1);
            time = null;
            int second = 0;

            try {
                second += Integer.parseInt(StrSecond);
            } catch (Exception var10) {
                Logger.e("F.getSecond()", var10);
            }

            try {
                second += Integer.parseInt(StrMinutes) * 60;
            } catch (Exception var9) {
                Logger.e("F.getSecond()", var9);
            }

            try {
                second += Integer.parseInt(StrHours) * 3600;
            } catch (Exception var8) {
                Logger.e("F.getSecond()", var8);
            }

            return second;
        }
    }

    public static String getSecureRequestText(String path) {
        if(!TextUtils.isEmpty(SECRET) && isTimeStampValid()) {
            String timeStampText = getTimeStampText();
            String _t_Data = "&_t_=" + timeStampText;
            String _s_Data = getTokenRequestText(timeStampText, path);
            return _t_Data + _s_Data;
        } else {
            return "";
        }
    }

    private static String getTimeStampText() {
        long timeStamp = System.currentTimeMillis() / 1000L + TIME_STAMP.longValue();
        return String.valueOf(timeStamp);
    }

    private static String getTokenRequestText(String timeStampText, String path) {
        String tokenString = "GET:" + path + ":" + timeStampText + ":" + SECRET;
        String md5Token = md5(tokenString);
        return "&_s_=" + md5Token;
    }

    public static boolean isTimeStampValid() {
        return TIME_STAMP != null;
    }

    public static String byteToHexString(byte[] tmp) {
        char[] str = new char[32];
        int k = 0;

        for(int i = 0; i < 16; ++i) {
            byte byte0 = tmp[i];
            str[k++] = hexDigits[byte0 >>> 4 & 15];
            str[k++] = hexDigits[byte0 & 15];
        }

        String s = new String(str);
        return s;
    }
    private static final  MsgHandler sMsgHandler = new  MsgHandler(Looper.getMainLooper());
    private static Toast sToast;

    public static void showTips(int stringId) {
        showTips(ZLBApplication.mContext.getString(stringId), -1L);
    }

    public static void showTips(String tipsString) {
        showTips(tipsString, -1L);
    }

    public static void showTips(int stringId, long threshold) {
        showTips(ZLBApplication.mContext.getString(stringId), threshold);
    }


    public static void showToast(Object msgString) {
        if(msgString != null && !msgString.equals("")) {
            Message msg = new Message();
            Bundle data = new Bundle();
            data.putString("ToastMsg", "" + msgString);
            msg.what = 0;
            msg.setData(data);
            sMsgHandler.sendMessage(msg);
        }
    }


    public static void showTips(String tipsString, long threshold) {
        Logger.d("Zlb.showTips():" + tipsString);
        Message msg = Message.obtain();
        msg.what = 1;
        Bundle bundle = new Bundle();
        bundle.putString("tipsString", tipsString);
        bundle.putLong("threshold", threshold);
        msg.setData(bundle);
        sMsgHandler.sendMessage(msg);
    }

    public static void cancelTips() {
        sMsgHandler.sendEmptyMessage(2);
    }

    private static class MsgHandler extends Handler {
        private long previousToastShow;
        private String previousToastString = "";

        public MsgHandler(Looper looper) {
            super(looper);
        }

        public void handleMessage(Message msg) {
            switch(msg.what) {
                case 0:
                    if(Util.sToast == null) {
                        Util.sToast = Toast.makeText(ZLBApplication.mContext, msg.getData().getString("ToastMsg"), 1);
                    } else {
                        Util.cancelTips();
                        Util.sToast.setText(msg.getData().getString("ToastMsg"));
                    }

                    Util.sToast.show();
                    break;
                case 1:
                    this.handleShowTipsEvents(msg);
                    break;
                case 2:
                    if(Util.sToast != null) {
                        Util.sToast.cancel();
                    }
            }

            super.handleMessage(msg);
        }

        private void handleShowTipsEvents(Message msg) {
            long thisTime = System.currentTimeMillis();
            String thisTimeMsg = msg.getData().getString("tipsString");
            String temp = this.previousToastString;
            this.previousToastString = thisTimeMsg;
            long tempTime = this.previousToastShow;
            this.previousToastShow = thisTime;
            if(thisTimeMsg != null && (thisTime - tempTime > 3500L || !thisTimeMsg.equalsIgnoreCase(temp))) {
                Toast.makeText(ZLBApplication.mContext, msg.getData().getString("tipsString"), 0).show();
                this.previousToastShow = thisTime;
            } else {
                this.previousToastString = temp;
                this.previousToastShow = tempTime;
            }
        }
    }

}
