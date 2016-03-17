package powerkeymanager;

import java.util.HashMap;

import com.project.captchit2.Extreme_Emergency;

import android.annotation.SuppressLint;
import android.app.Service;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.location.LocationManager;
import android.os.IBinder;
import android.os.PowerManager;
import android.os.Vibrator;
import android.telephony.SmsManager;
import android.util.Log;

@SuppressWarnings("unused")
public class UpdateService extends Service {
		
		    BroadcastReceiver mReceiver;
		    SmsManager sms;
		    LocationManager lm;
		    static int count=0;
		    boolean flag=false;
		    long endTime=0;
		    HashMap<String, Boolean> map;
		    Vibrator v; // Vibrate for 500 milliseconds
		   
		    
		@Override
		public void onCreate() 
		{
		    super.onCreate();
		    try {
				v = (Vibrator) this.getSystemService(Context.VIBRATOR_SERVICE);
				try {
					
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				// register receiver that handles screen on and screen off logic
				sms=SmsManager.getDefault();
				
				IntentFilter filter = new IntentFilter(Intent.ACTION_SCREEN_ON);
				filter.addAction(Intent.ACTION_SCREEN_OFF);
				
				
				mReceiver = new MyReceiver();
				registerReceiver(mReceiver, filter);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				Log.e("updateService", "onCreate");
				e.printStackTrace();
			}
		    
		}
		
		@Override
		public void onDestroy() 
		{
		
		    try {
				unregisterReceiver(mReceiver);
				Log.i("onDestroy Reciever", "Called");
			} catch (Exception e) {
				// TODO Auto-generated catch block
				Log.e("updateService", "onDestroy");
				e.printStackTrace();
			}
		
		    super.onDestroy();
		}
		
		@SuppressLint("Wakelock")
		@Override
		public void onStart(Intent intent, int startId) 
		{
				    try {
						boolean screenOn = intent.getBooleanExtra("screen_state", false);
						Log.e("Log_tag","+++ 3---");
						if (!screenOn || screenOn) {
							if (flag == false) 
							{
								endTime = System.currentTimeMillis() + 4*1000;
								flag=true;
								count=0;
							}
							Log.e("Log_tag","+++ 3---"+count);
							if (flag == true) 
							{
								count++;
								if(System.currentTimeMillis()< endTime && count ==3)
								    {
						    		  Log.e("Log_tag","+++ 3---"+count);
						    		  PowerManager pm = (PowerManager) getSystemService(Context.POWER_SERVICE);
						    		  PowerManager.WakeLock wl = pm.newWakeLock(
						                      PowerManager.SCREEN_DIM_WAKE_LOCK
						                      | PowerManager.ON_AFTER_RELEASE,
						                      "");
						    		  wl.acquire();
						    		  										/**
						    		  										 * 
						    		  										 */
						    		  
						    		  try {
										Intent inte = new Intent();
										  intent.setAction("powerkeymanager.MyReceiver");
										  sendBroadcast(inte);
									} catch (Exception e1) {
										// TODO Auto-generated catch block
										e1.printStackTrace();
									}
						    		  										/**
						    		  										 * 1
						    		  										 */
						             
						    		  Intent smsLoc= new Intent(getApplicationContext(),Extreme_Emergency.class);
										smsLoc.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
										getApplicationContext().startActivity(smsLoc);
										v.vibrate(200);
										try {
													wait(endTime - System.currentTimeMillis());
													count++;
										} catch (Exception e) {
										}
									
										count=0;
										flag=false;
										wl.acquire();
									}
								else if (System.currentTimeMillis() > endTime) {
									count=0;
									flag=false;
									endTime=0;
								}
							}
							
						}
					} catch (Exception e) {
						// TODO Auto-generated catch block
						Log.e("updateService", "onstart");
						e.printStackTrace();
					}
		}
		
		@Override
		public IBinder onBind(Intent intent) {
		    // TODO Auto-generated method stub
		    return null;
		}
}