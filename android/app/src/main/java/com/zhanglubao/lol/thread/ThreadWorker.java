package com.zhanglubao.lol.thread;


import com.zhanglubao.lol.Const;

import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;

public class ThreadWorker {
	static ExecutorService executorService;
	
	/**
	 * 线程池里跑runnable
	 * 
	 * @param runnable
	 * @return
	 */
	public static Future<?> executeRunalle(Runnable runnable) {
		if (executorService == null) {
			executorService = Executors.newFixedThreadPool(Const.net_pool_size);
		}
		return executorService.submit(runnable);
	}
	
	public static Future execuse(final Task task){

		Future future=executeRunalle(new Runnable() {
			@Override
			public void run() {
				try {
					task.doInBackground();
				} catch (Exception e) {
					task.transfer(null, Task.TRANSFER_DOERROR);
					return;
				}
				task.transfer(null, Task.TRANSFER_DOUI);
			}
		});
		return future;
	}
	
}
