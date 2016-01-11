

package com.zhanglubao.lol.downloader;

import android.graphics.drawable.Drawable;
import android.os.Handler;
import android.os.Message;
import android.widget.ImageView;

import com.zhanglubao.lol.downloader.util.Logger;
import com.zhanglubao.lol.util.Util;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.lang.ref.SoftReference;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;


public class AsyncImageLoader {
	private static final String TAG = "AsyncImageLoader";
	private static AsyncImageLoader instance = null;
	// 图片软引用
	private HashMap<String, SoftReference<Drawable>> imageCache;


	public synchronized static AsyncImageLoader getInstance() {
		if (instance == null)
			instance = new AsyncImageLoader();
		return instance;
	}


	private AsyncImageLoader() {
		imageCache = new HashMap<String, SoftReference<Drawable>>();
	}

	public Drawable loadDrawable(final ImageView imageView, final String url,
			final String pathName, final DownloadInfo info) {

		// imageView.setTag(pathName);
		if (imageCache.containsKey(pathName)) {
			Drawable drawable = imageCache.get(pathName).get();
			if (drawable != null)
				return drawable;
		}
		Drawable d = null;
		try {
			d = Drawable.createFromPath(pathName);
		} catch (OutOfMemoryError e) {
			// this.getImageCache().clearCaches();
			System.gc();
			Logger.e(TAG, "AsyncImageLoader#loadDrawable()", e);
		}
		if (d != null) {
			imageCache.put(pathName, new SoftReference<Drawable>(d));
			return d;
		}


		if (Util.hasInternet() && info.isThumbnailDownloading == false)
			new Thread() {
				@Override
				public void run() {
					try {
						info.isThumbnailDownloading = true;
						String u;
						if (url == null || url.length() == 0) {
							if (!DownloadUtils.getVideoInfo(info)) {
								info.isThumbnailDownloading = false;
								return;
							}

							u = info.imgUrl;
						} else {
							u = url;
						}
						Logger.d(TAG, "url:" + u);
						InputStream i = loadImageFromUrl(u);
						File file = new File(pathName);
						if (file.exists()) {
							file.delete();
						}
						FileOutputStream fos = new FileOutputStream(file);
						byte[] data = new byte[1024];
						int len1 = 0;
						while ((len1 = i.read(data)) > 0) {
							fos.write(data, 0, len1);
						}
						fos.flush();
						fos.close();
						i.close();
						Drawable d = Drawable.createFromPath(pathName);
						imageCache
								.put(pathName, new SoftReference<Drawable>(d));

					} catch (IOException e) {
						Logger.e(TAG, "loadDrawable", e);
					} catch (Exception e) {
						Logger.e(TAG, "loadDrawable", e);
					} finally {
						info.isThumbnailDownloading = false;
					}
				}
			}.start();
		return null;
	}

	public Drawable loadDrawable(final String imageUrl,
			final ImageCallback imageCallback) {
		if (imageCache.containsKey(imageUrl)) {
			SoftReference<Drawable> softReference = imageCache.get(imageUrl);
			Drawable drawable = softReference.get();
			if (drawable != null) {
				return drawable;
			}
		}
		final Handler handler = new Handler() {
			public void handleMessage(Message message) {
				imageCallback.imageLoaded((Drawable) message.obj, imageUrl);
			}
		};
		new Thread() {
			@Override
			public void run() {
				Drawable d = Drawable.createFromStream(
						loadImageFromUrl(imageUrl), "src");
				imageCache.put(imageUrl, new SoftReference<Drawable>(d));
				Message message = handler.obtainMessage(0, d);
				handler.sendMessage(message);
			}
		}.start();
		return null;
	}

	private InputStream loadImageFromUrl(String url) {
		try {
			URL u = new URL(url);
			HttpURLConnection c = (HttpURLConnection) u.openConnection();
			c.setDoInput(true);
			c.connect();
			return (InputStream) c.getInputStream();
		} catch (MalformedURLException e) {
			Logger.e(TAG, "loadImageFromUrl", e);
		} catch (IOException e) {
			Logger.e(TAG, "loadImageFromUrl", e);
		}
		return null;
	}

	public interface ImageCallback {
		public void imageLoaded(Drawable imageDrawable, String imageUrl);
	}

    public void stop()
    {
        imageCache.clear();
    }
}
