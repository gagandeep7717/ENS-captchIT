package com.project.captchit2;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStream;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

import com.project.commonUtility.AlertDialogManager;

import powerkeymanager.UpdateService;

import android.app.Activity;
import android.app.KeyguardManager;
import android.app.KeyguardManager.KeyguardLock;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;

@SuppressWarnings("deprecation")
public class Photo_intent extends Activity{

	Button btn_Take_photo,btn_Done,btn_view_complaints;
	ImageView iv;
	Bitmap bmp1;
	String path,File_Name;
	Uri outputFileUri;
	AlertDialogManager alert;
	private static final String PNG_FILE_PREFIX = "IMG_";
	private static final String PNG_FILE_SUFFIX = ".png";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.photo_intent);
		
		/**
		 * power key manager
		 */
		  Context context =Photo_intent.this;
          KeyguardManager _guard = (KeyguardManager) context
                  .getSystemService(Context.KEYGUARD_SERVICE);
          KeyguardLock _keyguardLock = _guard
                  .newKeyguardLock("KeyguardLockWrapper");
          _keyguardLock.disableKeyguard();

          Photo_intent.this.startService(new Intent(
        		  Photo_intent.this, UpdateService.class));
        /**
         * 
         */
		
          alert = new AlertDialogManager();
          
		init();
		
		/**
		 * TAKE PHOTO
		 */
		Intent i=new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
		startActivityForResult(i,1);
	}

	private void init() {
		// TODO Auto-generated method stub
		btn_Take_photo=(Button)findViewById(R.id.btn_TakePhoto);
		btn_Done=(Button)findViewById(R.id.btn_Done);
		btn_view_complaints=(Button)findViewById(R.id.btn_view_prev_comp);
		iv=(ImageView)findViewById(R.id.iv);
		
		
		/**
		 * take photo
		 */
		btn_Take_photo.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent i=new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
				startActivityForResult(i,1);
			}
		});
		
		/**
		 * done button
		 */
		btn_Done.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				if (bmp1 != null) {
					// TODO Auto-generated method stub
					Intent open_main = new Intent(Photo_intent.this,
							MainActivity.class);
					open_main.putExtra("filepath", path);
					open_main.putExtra("file_name", File_Name);
					startActivity(open_main);
					finish();
				}
				else
				{
					alert.showAlertDialog(Photo_intent.this, "Photo Not Captured...", "Please Take Photo First!!!", false);
				}
			}
		});
		
		
		btn_view_complaints.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				Intent open_complaints = new Intent(Photo_intent.this,View_complaints.class);
				startActivity(open_complaints);
			}
		});
	}

	
	/** 	
	 * 		@see android.app.Activity#onActivityResult(int, int, android.content.Intent)
	 */
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if(resultCode == RESULT_OK && requestCode == 1)
		{
			Bundle bundle = data.getExtras();
			bmp1 =(Bitmap) bundle.get("data");
			iv.setImageBitmap(bmp1);
			try {
				new saveIMG().execute(createImageFileName());
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}
	
	/**
	 * Generate Image File Name Using TimeStamp
	 * @return
	 * @throws IOException
	 */
	private String createImageFileName() throws IOException {
		// Create an image file name
		String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss", Locale.getDefault()).format(new Date());
		String imageFileName = PNG_FILE_PREFIX + timeStamp + ""+PNG_FILE_SUFFIX;
		return imageFileName;
	}
	
	
	/**
	 * save IMAGE FROM IMAGEVIEW TO ABSOLUTE PATH
	 */
	public class saveIMG extends AsyncTask<String, Integer, Integer> 
	{

		@Override
		protected Integer doInBackground(String... filename) {
			OutputStream fOut = null;
		     try 
		     {
			     File root = new File(Environment.getExternalStorageDirectory()
			    		 + File.separator + getResources().getString(R.string.app_name) + File.separator);
			     		root.mkdirs();
			     		File_Name=filename[0];
			     		File sdImageMainDirectory = new File(root, File_Name);
			     		outputFileUri = Uri.fromFile(sdImageMainDirectory);
			     		path=sdImageMainDirectory.getAbsolutePath();
			     		fOut = new FileOutputStream(sdImageMainDirectory);
			     		Log.e("CameraSample", "Output : "+outputFileUri);
			     		
			     		 bmp1.compress(Bitmap.CompressFormat.PNG, 100, fOut);
			 		    
			 		    MediaStore.Images.Media.insertImage(getContentResolver(), bmp1, path , "this picture Taken from " +
			 		    																		"Be Secured Application");
			 		    fOut.flush();
			 		    fOut.close();
			 } 
		     catch (Exception e) 
		     {
		    	 Log.e("Corpo", ""+e.getMessage());
			    Toast.makeText(Photo_intent.this, "Error occured. Please try again later.",
			      Toast.LENGTH_SHORT).show();
		     }
			return null;
		}
	}
}
