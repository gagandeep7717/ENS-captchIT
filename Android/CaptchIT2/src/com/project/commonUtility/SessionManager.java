package com.project.commonUtility;

import java.util.HashMap;



import android.annotation.SuppressLint;
import android.content.Context;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;

public class SessionManager 
{
	// Shared Preferences
	SharedPreferences pref;
	
	// Editor for Shared preferences
	Editor editor;
	
	// Context
	Context _context;
	
	// Shared pref mode
	int PRIVATE_MODE = 0;
	
	// Sharedpref file name
	private static final String PREF_NAME = "ASTIWZPref";
	
	// All Shared Preferences Keys
	
	// User name (make variable public to access from outside)
	public static final String KEY_NAME = "name";
	public static final String KEY_MOBILE_NO = "mobileno";
	public static final String KEY_Email_ID = "emailid";
	
	// Constructor
	@SuppressLint("CommitPrefEdits")
	public SessionManager(Context context)
	{
		this._context = context;
		pref = _context.getSharedPreferences(PREF_NAME, PRIVATE_MODE);
		editor = pref.edit();
	}
	
	/**
	 * Create login session
	 * */
	public void createSession(String name, String mobileno, String emailid)
	{
		// Storing login value as TRUE
		editor.putString(KEY_NAME, name);
		editor.putString(KEY_MOBILE_NO, mobileno);
		editor.putString(KEY_Email_ID, emailid);
		editor.commit();
	}	
	
	/**
	 * Check login method will check user login status
	 * If false it will redirect user to login page
	 * Else won't do anything
	 * */
	
	
	
	
	/**
	 * Get stored session data
	 * */
	public HashMap<String, String> getUserDetails(){
		HashMap<String, String> user = new HashMap<String, String>();
		// user name
		user.put(KEY_NAME, pref.getString(KEY_NAME, null));
		user.put(KEY_MOBILE_NO, pref.getString(KEY_MOBILE_NO, null));
		user.put(KEY_Email_ID, pref.getString(KEY_Email_ID, null));
		return user;
	}
	
	/**
	 * Clear session details
	 * */
	
	
	/**
	 * Quick check for login
	 * **/
	// Get Login State
}
