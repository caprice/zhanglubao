package com.zhanglubao.lol.util;

import android.annotation.TargetApi;
import android.content.Context;
import android.content.pm.ApplicationInfo;
import android.content.pm.PackageManager.NameNotFoundException;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.NetworkInfo.State;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.os.Message;
import android.os.Build.VERSION;
import android.text.TextUtils;
import android.view.ViewConfiguration;
import android.widget.Toast;

import com.zhanglubao.lol.ZLBApplication;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;
import java.util.Random;
import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.KeyGenerator;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.spec.SecretKeySpec;
import org.json.JSONException;
import org.json.JSONObject;

public final class PlayerUtil {
    public static final int CHINESE = 0;
    public static final int NUMBER_OR_CHARACTER = 1;
    public static final int NUMBER_CHARACTER = 2;
    public static final int MIX = 3;
    public static final String LINE_SEPARATOR = System.getProperty("line.separator");
    private static Random random = new Random(System.currentTimeMillis());
    static char[] hexDigits = new char[]{'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'};
    public static int flags;
    public static String TAG_GLOBAL = "UPlayer";
    public static final int EXCEPTION = -1;
    public static String ALGORITHM = "AES/ECB/NoPadding";
    private static final PlayerUtil.MsgHandler sMsgHandler = new PlayerUtil.MsgHandler(Looper.getMainLooper());
    private static Toast sToast;

    private PlayerUtil() {
    }



    public static String formatSize(float size) {
        long kb = 1024L;
        long mb = kb * 1024L;
        long gb = mb * 1024L;
        return size < (float)kb?String.format("%d B", new Object[]{Integer.valueOf((int)size)}):(size < (float)mb?String.format("%.1f KB", new Object[]{Float.valueOf(size / (float)kb)}):(size < (float)gb?String.format("%.1f MB", new Object[]{Float.valueOf(size / (float)mb)}):String.format("%.1f GB", new Object[]{Float.valueOf(size / (float)gb)})));
    }

    public static boolean isNull(String str) {
        return str == null || str.length() == 0;
    }

    public static boolean isFinalUrl(String url) {
        url = url.toLowerCase().trim();
        return url.endsWith(".3gp") || url.endsWith(".mp4") || url.endsWith(".3gphd") || url.endsWith(".flv") || url.endsWith(".3gp") || url.endsWith(".m3u8");
    }

    public static String getFinnalUrl(String url, String exceptionString) {
        try {
            if(isFinalUrl(url)) {
                return url;
            } else {
                HttpURLConnection e = (HttpURLConnection)(new URL(url)).openConnection();
                e.setInstanceFollowRedirects(false);
                e.connect();
                String newUrl = null;
                if(e.getResponseCode() == 302) {
                    newUrl = e.getHeaderField("Location");
                    e.disconnect();
                    return isFinalUrl(newUrl)?newUrl:getFinnalUrl(newUrl, exceptionString);
                } else {
                    return null;
                }
            }
        } catch (MalformedURLException var4) {
            exceptionString = exceptionString + var4.toString();
            Logger.e(TAG_GLOBAL, "Task_getVideoUrl.getLastUrl()," + exceptionString, var4);
            return null;
        } catch (IOException var5) {
            exceptionString = exceptionString + var5.toString();
            Logger.e(TAG_GLOBAL, "Task_getVideoUrl.getLastUrl()," + exceptionString, var5);
            return null;
        } catch (Exception var6) {
            return null;
        }
    }

    public static int rand(int maxvalue) {
        return (random.nextInt() << 1 >>> 1) % maxvalue;
    }

    public static void sendMessage(Handler mhandler, int msg) {
        try {
            Message e = Message.obtain();
            e.what = msg;
            mhandler.sendMessage(e);
        } catch (Exception var3) {
            Logger.e(TAG_GLOBAL, "F.sendMessage()", var3);
        }

    }

    public static String getJsonValue(JSONObject object, String name) {
        return object != null?object.optString(name):"";
    }

    public static int getJsonInit(JSONObject object, String name, int defaultValue) {
        try {
            return object.isNull(name)?defaultValue:object.getInt(name);
        } catch (JSONException var4) {
            Logger.d(TAG_GLOBAL, "F.getJsonInit()", var4);
            return defaultValue;
        }
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

    public static void out(int id, String str) {
        switch(id) {
            case -1:
                Logger.e(TAG_GLOBAL, "F.out()," + str);
                break;
            case 0:
                Logger.d(TAG_GLOBAL, "F.out()," + str);
                break;
            default:
                Logger.d(TAG_GLOBAL, "F.out()," + str);
        }

    }

    public static String getFormattedTime(long time) {
        String format = "yyyy-MM-dd HH:mm:ss";
        SimpleDateFormat sdf = new SimpleDateFormat(format, Locale.CHINESE);
        return sdf.format(new Date(time));
    }

    public static boolean isHD2Supported() {
        if(isNeonSupported()) {
            double totalMemory = getTotalMemory();
            double maxCpuFreq = getCpuMaxFreq();
            return totalMemory >= 1000000.0D && maxCpuFreq >= 1200000.0D;
        } else {
            return false;
        }
    }

    public static boolean isNeonSupported() {
        InputStream in = null;

        try {
            String[] e = new String[]{"/system/bin/cat", "/proc/cpuinfo"};
            ProcessBuilder cmd = new ProcessBuilder(e);
            Process process1 = cmd.start();
            in = process1.getInputStream();
            byte[] temp = new byte[1024];
            boolean count = false;
            ByteArrayOutputStream bao = new ByteArrayOutputStream();

            int count1;
            while((count1 = in.read(temp)) > 0) {
                bao.write(temp, 0, count1);
            }

            String cpuInfo = (new String(bao.toByteArray())).toLowerCase();
            if(cpuInfo.contains("neon") && cpuInfo.contains("armv7")) {
                return true;
            }
        } catch (Exception var17) {
            var17.printStackTrace();
        } finally {
            try {
                in.close();
            } catch (IOException var16) {
                var16.printStackTrace();
            }

        }

        return false;
    }

    public static double getTotalMemory() {
        InputStream in = null;

        try {
            String[] e = new String[]{"/system/bin/cat", "/proc/meminfo"};
            ProcessBuilder cmd = new ProcessBuilder(e);
            Process process = cmd.start();
            in = process.getInputStream();
            BufferedReader reader = new BufferedReader(new InputStreamReader(in));
            String content = null;

            do {
                if((content = reader.readLine()) == null) {
                    return 0.0D;
                }

                content = content.trim().toLowerCase();
            } while(!content.contains("memtotal"));

            double var7 = Double.valueOf(content.substring(content.indexOf(":") + 1, content.indexOf("kb")).trim()).doubleValue();
            return var7;
        } catch (Exception var17) {
            var17.printStackTrace();
            return 0.0D;
        } finally {
            try {
                in.close();
            } catch (IOException var16) {
                var16.printStackTrace();
            }

        }
    }

    public static double getCpuMaxFreq() {
        InputStream in = null;

        try {
            String[] e = new String[]{"/system/bin/cat", "/sys/devices/system/cpu/cpu0/cpufreq/cpuinfo_max_freq"};
            ProcessBuilder cmd = new ProcessBuilder(e);
            Process process = cmd.start();
            in = process.getInputStream();
            byte[] temp = new byte[1024];
            boolean count = false;
            ByteArrayOutputStream bao = new ByteArrayOutputStream();

            int count1;
            while((count1 = in.read(temp)) > 0) {
                bao.write(temp, 0, count1);
            }

            String cpuMaxFreq = new String(bao.toByteArray());
            double var9 = Double.valueOf(cpuMaxFreq).doubleValue();
            return var9;
        } catch (Exception var18) {
            var18.printStackTrace();
        } finally {
            try {
                in.close();
            } catch (IOException var17) {
                var17.printStackTrace();
            }

        }

        return 0.0D;
    }

    public static String getFinnalUrl(String url) {
        try {
            if(isFinalUrl(url)) {
                return url;
            } else {
                HttpURLConnection e = (HttpURLConnection)(new URL(url)).openConnection();
                e.setInstanceFollowRedirects(false);
                e.connect();
                String newUrl = null;
                if(e.getResponseCode() == 302) {
                    newUrl = e.getHeaderField("Location");
                    e.disconnect();
                    return isFinalUrl(newUrl)?newUrl:getFinnalUrl(newUrl);
                } else {
                    return null;
                }
            }
        } catch (MalformedURLException var3) {
            return null;
        } catch (IOException var4) {
            return null;
        }
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



    public static String getM3u8File(String path) {
        FileInputStream fin = null;
        ByteArrayOutputStream bao = null;

        try {
            fin = new FileInputStream(path);
            byte[] e = new byte[1024];
            boolean count = false;
            bao = new ByteArrayOutputStream();

            int count1;
            while((count1 = fin.read(e, 0, 1024)) > 0) {
                bao.write(e, 0, count1);
            }

            String var6 = new String(bao.toByteArray());
            return var6;
        } catch (Exception var18) {
            ;
        } finally {
            if(fin != null) {
                try {
                    fin.close();
                } catch (IOException var17) {
                    var17.printStackTrace();
                }
            }

            if(bao != null) {
                try {
                    bao.close();
                } catch (IOException var16) {
                    var16.printStackTrace();
                }
            }

        }

        return null;
    }



    public static byte[] decrypt(byte[] content, String password) {
        try {
            KeyGenerator e = KeyGenerator.getInstance("AES");
            byte[] raw = password.getBytes("utf-8");
            e.init(new SecureRandom(raw));
            SecretKeySpec key = new SecretKeySpec(raw, ALGORITHM);
            Cipher cipher = Cipher.getInstance(ALGORITHM);
            cipher.init(2, key);
            return cipher.doFinal(content);
        } catch (NoSuchAlgorithmException var6) {
            var6.printStackTrace();
        } catch (NoSuchPaddingException var7) {
            var7.printStackTrace();
        } catch (InvalidKeyException var8) {
            var8.printStackTrace();
        } catch (IllegalBlockSizeException var9) {
            var9.printStackTrace();
        } catch (BadPaddingException var10) {
            var10.printStackTrace();
        } catch (UnsupportedEncodingException var11) {
            var11.printStackTrace();
        }

        return null;
    }



    @TargetApi(14)
    public static boolean hasVirtualButtonBar(Context context) {
        return VERSION.SDK_INT >= 18?!ViewConfiguration.get(context).hasPermanentMenuKey():false;
    }

    public static String intToIP(int ip) {
        return "" + (ip & 255) + '.' + (ip >> 8 & 255) + '.' + (ip >> 16 & 255) + '.' + (ip >> 24 & 255);
    }



    public static String getHlsFinnalUrl(String url) {
        try {
            if(TextUtils.isEmpty(url)) {
                return "";
            } else {
                HttpURLConnection e = (HttpURLConnection)(new URL(url)).openConnection();
                e.setInstanceFollowRedirects(false);
                e.connect();
                String newUrl = null;
                int code = e.getResponseCode();
                if(code == 302) {
                    newUrl = e.getHeaderField("Location");
                    e.disconnect();
                    return newUrl;
                } else {
                    return null;
                }
            }
        } catch (MalformedURLException var4) {
            return null;
        } catch (IOException var5) {
            return null;
        }
    }

    public static String getClientId(Context ctx) {
        try {
            ApplicationInfo e = ctx.getPackageManager().getApplicationInfo(ctx.getPackageName(), 128);
            Object client_id = e.metaData.get("client_id");
            Logger.d("clientId", "client_id: " + client_id.toString());
            return client_id.toString();
        } catch (NameNotFoundException var3) {
            Logger.e("clientId", "get client_id failed");
            var3.printStackTrace();
            return "";
        }
    }

    public static String getClientSecret(Context ctx) {
        try {
            ApplicationInfo e = ctx.getPackageManager().getApplicationInfo(ctx.getPackageName(), 128);
            Object client_id = e.metaData.get("client_secret");
            Logger.d("clientSecret", "client_secret: " + client_id.toString());
            return client_id.toString();
        } catch (NameNotFoundException var3) {
            Logger.e("clientSecret", "get client_secret failed");
            var3.printStackTrace();
            return "";
        }
    }

    public static boolean hasInternet(Context context) {
        ConnectivityManager m = (ConnectivityManager)context.getSystemService("connectivity");
        if(m == null) {
            Logger.d("NetWorkState", "Unavailabel");
            return false;
        } else {
            NetworkInfo[] info = m.getAllNetworkInfo();
            if(info != null) {
                for(int i = 0; i < info.length; ++i) {
                    if(info[i].getState() == State.CONNECTED) {
                        Logger.d("NetWorkState", "Availabel");
                        return true;
                    }
                }
            }

            return false;
        }
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

    public static String join(double[] objs) {
        if(objs == null) {
            return "";
        } else {
            StringBuffer s = new StringBuffer();
            int i = 0;

            for(int n = objs.length; i < n; ++i) {
                s.append(objs[i]);
                if(i != n - 1) {
                    s.append(",");
                }
            }

            return s.toString();
        }
    }
    public static String join(int[] objs) {
        if(objs == null) {
            return "";
        } else {
            StringBuffer s = new StringBuffer();
            int i = 0;

            for(int n = objs.length; i < n; ++i) {
                s.append(objs[i]);
                if(i != n - 1) {
                    s.append(",");
                }
            }

            return s.toString();
        }
    }

    public static String join(long[] objs) {
        if(objs == null) {
            return "";
        } else {
            StringBuffer s = new StringBuffer();
            int i = 0;

            for(int n = objs.length; i < n; ++i) {
                s.append(objs[i]);
                if(i != n - 1) {
                    s.append(",");
                }
            }

            return s.toString();
        }
    }

    public static double[] string2double(String[] numbers) {
        int n = numbers.length;
        double[] nums = new double[n];

        try {
            for(int e = 0; e < n; ++e) {
                nums[e] = Double.parseDouble(numbers[e]);
            }

            return nums;
        } catch (NumberFormatException var4) {
            return nums;
        }
    }

    public static int[] string2int(String[] numbers) {
        int n = numbers.length;
        int[] nums = new int[n];

        try {
            for(int e = 0; e < n; ++e) {
                nums[e] = Integer.parseInt(numbers[e]);
            }

            return nums;
        } catch (NumberFormatException var4) {
            return nums;
        }
    }

    public static long[] string2long(String[] numbers) {
        int n = numbers.length;
        long[] nums = new long[n];

        try {
            for(int e = 0; e < n; ++e) {
                nums[e] = Long.parseLong(numbers[e]);
            }

            return nums;
        } catch (NumberFormatException var4) {
            return nums;
        }
    }

    public static boolean deleteFile(File file) {
        if(file == null) {
            return false;
        } else if(file.exists()) {
            if(file.isFile()) {
                return file.delete();
            } else {
                if(file.isDirectory()) {
                    File[] files = file.listFiles();
                    if(files != null) {
                        for(int i = 0; i < files.length; ++i) {
                            if(!deleteFile(files[i])) {
                                return false;
                            }
                        }
                    }
                }

                return file.delete();
            }
        } else {
            return false;
        }
    }

    public static String formatTimeForHistory(double s) {
        try {
            long e = (long)s;
            String seconds = "00" + e % 60L;
            String minutes = String.valueOf(e / 60L);
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

    public static void showTips(int stringId) {
        showTips(ZLBApplication.mContext.getString(stringId), -1L);
    }

    public static void showTips(String tipsString) {
        showTips(tipsString, -1L);
    }

    public static void showTips(int stringId, long threshold) {
        showTips(ZLBApplication.mContext.getString(stringId), threshold);
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
                    if(PlayerUtil.sToast == null) {
                        PlayerUtil.sToast = Toast.makeText(ZLBApplication.mContext, msg.getData().getString("ToastMsg"), 1);
                    } else {
                        PlayerUtil.cancelTips();
                        PlayerUtil.sToast.setText(msg.getData().getString("ToastMsg"));
                    }

                    PlayerUtil.sToast.show();
                    break;
                case 1:
                    this.handleShowTipsEvents(msg);
                    break;
                case 2:
                    if(PlayerUtil.sToast != null) {
                        PlayerUtil.sToast.cancel();
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
