package com.zhanglubao.lol.downloader.util;

import java.util.regex.Pattern;

/**
 * common string utils
 *
 * @author Kevin
 */
public class StringUtil {

    // email
    private final static Pattern emailer = Pattern.compile("\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*");

    /**
     * if string is empty
     *
     * @param input
     * @return boolean
     */
    public static boolean isEmpty(String input) {
        if (input == null || "".equals(input))
            return true;

        for (int i = 0; i < input.length(); i++) {
            char c = input.charAt(i);
            if (c != ' ' && c != '\t' && c != '\r' && c != '\n') {
                return false;
            }
        }
        return true;
    }

    /**
     * if email is valid
     *
     * @param email
     * @return
     */
    public static boolean isEmail(String email) {
        if (email == null || email.trim().length() == 0)
            return false;
        return emailer.matcher(email).matches();
    }

    /**
     * 半角转换为全角
     *
     * @param input
     * @return
     */
    public static String toDBC(String input) {
        char[] c = input.toCharArray();
        for (int i = 0; i < c.length; i++) {
            if (c[i] == 12288) {
                c[i] = (char) 32;
                continue;
            }
            if (c[i] > 65280 && c[i] < 65375)
                c[i] = (char) (c[i] - 65248);
        }
        return new String(c);
    }

    public static String join(Object... objs) {
        if (objs == null)
            return "";
        StringBuffer s = new StringBuffer();
        for (int i = 0, n = objs.length; i < n; i++) {
            s.append(objs[i]);
            if (i != n - 1)
                s.append(",");
        }
        return s.toString();
    }

    public static String join(int[] objs) {
        if (objs == null)
            return "";
        StringBuffer s = new StringBuffer();
        for (int i = 0, n = objs.length; i < n; i++) {
            s.append(objs[i]);
            if (i != n - 1)
                s.append(",");
        }
        return s.toString();
    }

    public static String join(long[] objs) {
        if (objs == null)
            return "";
        StringBuffer s = new StringBuffer();
        for (int i = 0, n = objs.length; i < n; i++) {
            s.append(objs[i]);
            if (i != n - 1)
                s.append(",");
        }
        return s.toString();
    }

    public static String formatSize2(float size) {
        long l1 = 1000L * 1000L;
        long l2 = l1 * 1000L;
        if (size < (float) 1000L) {
            Object[] arrayOfObject4 = new Object[1];
            arrayOfObject4[0] = Integer.valueOf((int) size);
            return String.format("%dB", arrayOfObject4);
        }
        if (size < (float) l1) {
            Object[] arrayOfObject3 = new Object[1];
            arrayOfObject3[0] = Float.valueOf(size / (float) 1000L);
            return String.format("%.0fKB", arrayOfObject3);
        }
        if (size < (float) l2) {
            Object[] arrayOfObject2 = new Object[1];
            arrayOfObject2[0] = Float.valueOf(size / (float) l1);
            return String.format("%.0fMB", arrayOfObject2);
        }
        Object[] arrayOfObject1 = new Object[1];
        arrayOfObject1[0] = Float.valueOf(size / (float) l2);
        return String.format("%.0fGB", arrayOfObject1);
    }
}
