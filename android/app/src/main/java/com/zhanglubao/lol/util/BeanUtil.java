package com.zhanglubao.lol.util;

import java.lang.reflect.Field;

public class BeanUtil {

	/**
	 * 对象copy只拷贝非空属性
	 * 
	 * @param from
	 * @param to
	 */
	public static void copyBeanWithOutNull(Object from, Object to) {
		Class<?> beanClass = from.getClass();
		Field[] fields = beanClass.getFields();
		for (int i = 0; i < fields.length; i++) {
			Field field = fields[i];
			field.setAccessible(true);
			try {
				Object value = field.get(from);
				if (value != null) {
					field.set(to, value);
				}
			} catch (Exception e) {
			}
		}
	}
	/**
	 * 对象copy
	 * 
	 * @param from
	 * @param to
	 */
	public static void copyBean(Object from, Object to) {
		Class<?> beanClass = from.getClass();
		Field[] fields = beanClass.getFields();
		for (int i = 0; i < fields.length; i++) {
			Field field = fields[i];
			field.setAccessible(true);
			try {
				Object value = field.get(from);
				field.set(to, value);
			} catch (Exception e) {
			}
		}
	}
	
	
	

	public static Field getDeclaredField(Class clazz, String name) {
		try {
			return clazz.getDeclaredField(name);
		} catch (SecurityException e) {
			e.printStackTrace();
		} catch (NoSuchFieldException e) {
			e.printStackTrace();
		}
		return null;
	}

	/**
	 * 获取属性
	 * 
	 * @param o
	 * @param field
	 * @return
	 */
	public static Object getProperty(Object o, String field) {
		try {
			Field f = o.getClass().getDeclaredField(field);
			return f.get(o);
		} catch (Exception e) {
			e.printStackTrace();
		}
		return null;
	}

	/**
	 * 添加屬性
	 * 
	 * @param o
	 * @param field
	 * @param value
	 */
	public static void setProperty(Object o, String field, Object value) {
		try {
			Field f = o.getClass().getDeclaredField(field);
			f.setAccessible(true);
			f.set(o, value);
		} catch (Exception e) {
			e.printStackTrace();
		}

	}

}
