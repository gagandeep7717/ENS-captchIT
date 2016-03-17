package com.project.captchit2;


import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import com.project.commonUtility.AlertDialogManager;
import com.project.commonUtility.ConnectionDetector;
import com.project.commonUtility.CustomHttpClient;
import com.project.commonUtility.GPSTracker;
import com.project.commonUtility.SessionManager;

import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.widget.Toast;

@TargetApi(Build.VERSION_CODES.GINGERBREAD)
public class Extreme_Emergency extends Activity
{
	
	String username,mobileno;
	
	GPSTracker gps;
	SessionManager session;
	AlertDialogManager alert;
	HashMap<String, String>map1;
	ArrayList<NameValuePair>postParameters;
	double longitude;
	double lattitude;
	String location_address ="";
	
	@SuppressLint("NewApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) 
	{
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		if (android.os.Build.VERSION.SDK_INT > 9)
	        StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().detectDiskReads().detectDiskWrites().detectNetwork().penaltyLog().build());
		setContentView(R.layout.extream_emergncy);
		init();
		get_location();
		emerg_postdata();
	}

	private void init() 
	{
		alert = new AlertDialogManager();
		session = new SessionManager(this);
		gps=new GPSTracker(this);
		map1=session.getUserDetails();
		username = map1.get(SessionManager.KEY_NAME);
		mobileno = map1.get(SessionManager.KEY_MOBILE_NO);
	}

	private void get_location() 
	{
	ConnectionDetector cd = new ConnectionDetector(this);
		
		if(cd.isConnectingToInternet())
		{
			try {
				Location l; 
				l=gps.getLocation();
				 longitude = gps.getLongitude();
				 lattitude = gps.getLatitude();
				Log.e("gps","-->"+ l+ "--->Longitude :"+longitude +" Lattitude :"+lattitude);
				
						
						try{
							 Geocoder geo = new Geocoder(Extreme_Emergency.this.getApplicationContext(), Locale.getDefault());
							 List<Address> addresses = geo.getFromLocation(lattitude, longitude, 1);
							  if (addresses.isEmpty()) {
								  alert.showAlertDialog(Extreme_Emergency.this, "Can not Get Your Location", "Check Your Internet Service...", false);
							  }
//						  else {
							     if (addresses.size() > 0) {       
							        Log.d("gps",addresses.get(0).getFeatureName() + ","
							          + addresses.get(0).getLocality()+", " 
							          + addresses.get(0).getAdminArea() + "," 
							          + addresses.get(0).getCountryName());
							        location_address= addresses.get(0).getFeatureName() + ","
									          + addresses.get(0).getLocality()+", " 
									          + addresses.get(0).getAdminArea() + "," 
									          + addresses.get(0).getCountryName() +"-"
									          + addresses.get(0).getPostalCode();
							        Toast.makeText(Extreme_Emergency.this, "Your location is : "+location_address, Toast.LENGTH_LONG).show();
							     }
//						  }
							}
							catch (Exception e) {
							    e.printStackTrace(); 
							}
			} catch (Exception e) {
				// TODO Auto-generated catch block
				alert.showAlertDialog(getBaseContext(), "Location Error", "Cant get location!!!!", false);
			}
		}
		else
		{
			
			alert.showAlertDialog(Extreme_Emergency.this, "Can not Get Your Location", "Check Your Internet Service...", false);
		}
		
	}

	private void emerg_postdata()
	{
			ArrayList<NameValuePair> postParameters = new ArrayList<NameValuePair>();
			postParameters.add(new BasicNameValuePair("name",username));
			postParameters.add(new BasicNameValuePair("mobileno", mobileno));
			postParameters.add(new BasicNameValuePair("location", location_address));
			postParameters.add(new BasicNameValuePair("type", "extreme_emergency"));
			postParameters.add(new BasicNameValuePair("lat", String.valueOf(lattitude)));
			postParameters.add(new BasicNameValuePair("longi", String.valueOf(longitude)));
			String response = null;
			Log.e("Log_e", "111");
			try 
			{
				response = CustomHttpClient.executeHttpPost("http://103.12.211.176/~captchit/extreme_postdata.php",postParameters);
				String result = response.toString();
				Log.e("Log_e", "Result string to check---> " + result);
				Log.e("Log_e", "222");

				Toast.makeText(this, "Emergency Help Requested :",Toast.LENGTH_LONG).show();
			} 
			catch (Exception e) 
			{
				e.printStackTrace();
				Log.e("Log_e", "Exception " + e.getMessage());
			}
	}
}

