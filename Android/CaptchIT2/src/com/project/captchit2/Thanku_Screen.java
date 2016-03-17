package com.project.captchit2;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.Toast;

public class Thanku_Screen extends Activity{

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.thanku_screen);
		
		Button btnback =(Button)findViewById(R.id.btnBack) ;
		Button btnexit =(Button)findViewById(R.id.btnExit) ;
		
		
		btnback.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				Intent photo_intent = new Intent(Thanku_Screen.this,Photo_intent.class);
				startActivity(photo_intent);
				Toast.makeText(Thanku_Screen.this, "Capture image if you want another complaint", Toast.LENGTH_LONG).show();
				finish();
			}
		});
		
		
		btnexit.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				// TODO Auto-generated method stub
				finish();
			}
		});
	}

}
