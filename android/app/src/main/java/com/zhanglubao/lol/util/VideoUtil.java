package com.zhanglubao.lol.util;

import android.util.Base64;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

/**
 * Created by rocks on 15/12/20.
 */
public class VideoUtil {

    private static final byte[] TRANSFORM_TABLE = {
            63, 121, -44, 54, 86, -68, 114, 15, 108, 94, 77, -15, 89, 46, -81, 4, -114, 69,
            -88, -79, -26, 91, 50, -19, -37, 38, 27, -80, 7, 32, -64, 127, -41, 27, -49,
            -89, 3, 42, 52, 29, 86, 122, 6, -35, -110, -1, -57, 41, 52, -13, -73, 10, 48,
            49, 92, 117, 67, 72, 45, 121, 93, -63, 101, -90, 73, 108, -29, -91, 7, 46, -110,
            85, 0, 81, 67, 83, 113, 67, 9, -57, 116, -102, -26, 15, 92, -14, -91, 90, 56,
            -76, 18, 1, 57, 95, -1, 83, 67, -84, 52, 117, -93, 86, 116, -58, 120, -112, 70,
            -88, -123, -45, -122, 10, 38, 39, -10, -60, -114, 93, 31, 25, 1, -120, -121,
            -66, -40, 74, -69, 83, 101, -86, 107, 121, -6, 109, 50, 111, -33, 62, 27, -63,
            -33, 1, 52, 81, 83, 109, -59, 122, 11, -57, -75, 34, 58, 38, -75, -115, 62, -46,
            7, -114, -60, -20, 55, 4, -107, -110, -62, 103, -21, 40, 56, -62, -110, -91,
            -64, 53, -69, 123, -87, 66, -67, 57, 91, 74, 82, 13, 14, 109, -77, -108, -28,
            -78, 103, -85, -37, -47, -33, -33, 97, -103, 102, -96, -78, -116, 57, 55, 91,
            20, 80, -66, -82, -77, -78, 39, -63, 19, 12, -2, 93, -32, 65, -25, 89, 104,
            -51, -102, 76, -68, -86, -90, 121, 39, -83, -118, -102, 110, 113, -3, -23, 52,
            -71, -16, -21, 72, -99, -86, -120, -16, 2, 114, 72, -50, 56, 73, -56, 117
    };

    public static String parse( String content) {
        try {

            String xml = decryptResult(content);
            String[] mediaInfo = parseXml(xml);
            return mediaInfo[1];

        } catch (Throwable t) {
            t.printStackTrace();
        }
        return null;
    }

    private static String parsePage(String pageUrl) throws Throwable {
        String enPageUrl = URLEncoder.encode(pageUrl, "UTF-8");
        String url = "http://m.flvcd.com/parse_m3u8.php?url="+pageUrl;
        HttpURLConnection conn = (HttpURLConnection) new URL(url).openConnection();
        conn.connect();

        String resp = null;
        if (conn.getResponseCode() == HttpURLConnection.HTTP_OK) {
            InputStream is = conn.getInputStream();
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            byte[] buf = new byte[1024];
            int len = is.read(buf);
            while (len > 0) {
                baos.write(buf, 0, len);
                len = is.read(buf);
            }
            baos.close();
            is.close();
            resp = new String(baos.toByteArray(), "UTF-8");
        }
        conn.disconnect();

        return resp;
    }

    private static String decryptResult(String parseRes) throws Throwable {
        String resp = null;
        if (parseRes != null) {
            byte[] tmp = new byte[parseRes.length() / 2];
            for (int i = 0; i < tmp.length; i++) {
                int c1 = Character.digit(parseRes.charAt(i * 2), 16) << 4;
                int c2 = Character.digit(parseRes.charAt(i * 2 + 1), 16);
                tmp[i] = (byte) ((c1 | c2) & 0xff);
            }

            byte[] base64 = new byte[tmp.length];
            for (int i = 0; i < base64.length; i++) {
                base64[i] = (byte) (TRANSFORM_TABLE[i % 256] ^ tmp[i]);
            }
            resp = new String(Base64.decode(base64, Base64.DEFAULT), "UTF-8");
            System.out.println(resp);
        }

        return resp;
    }

    private static String[] parseXml(String xml) throws Throwable {
        String[] resp = null;
        if (xml != null) {
            String[] lines = xml.split("\n");
            String name = null;
            String url = null;
            for (String line : lines) {
                if (line.startsWith("<title><![CDATA[") && line.endsWith("]]></title>")) {
                    line = line.substring("<title><![CDATA[".length());
                    name = line.substring(0, line.length() - "]]></title>".length());
                } else if (line.startsWith("<U><![CDATA[") && line.endsWith("]]></U>")) {
                    line = line.substring("<U><![CDATA[".length());
                    url = line.substring(0, line.length() - "]]></U>".length());
                }
            }

            if (name != null && url != null) {
                resp = new String[] {name, url};
            }
        }
        return resp;
    }

}
