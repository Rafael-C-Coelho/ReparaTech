package pt.ipleiria.estg.dei.psi.projeto.reparatech;



import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.os.Bundle;
import android.text.InputType;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.TimePicker;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;

import com.android.volley.Response;

import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Calendar;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RepairBookingActivity extends AppCompatActivity implements BookingListener {

    private EditText etDate, etTime;
    Button btnDatePicker, btnTimePicker, btnMyCalendar, btnSend;
    
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_booking);


        etDate = findViewById(R.id.etDate);
        etTime = findViewById(R.id.etTime);
        btnMyCalendar = findViewById(R.id.btnMyCalendar);
        btnDatePicker = findViewById(R.id.btnDatePicker);
        btnTimePicker = findViewById(R.id.btnTimePicker);
        btnMyCalendar = findViewById(R.id.btnMyCalendar);
        btnSend = findViewById(R.id.btnSend);


        etDate.setInputType(InputType.TYPE_NULL);
        etTime.setInputType(InputType.TYPE_NULL);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);



        btnDatePicker.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showDateDialog(etDate);
            }
        });

        btnTimePicker.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showTimeDialog(etTime);
            }
        });

        btnMyCalendar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Fragment myBookingCalendar = new MyBookingCalendar();
                FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
                transaction.replace(R.id.RepairBooking, myBookingCalendar);
                transaction.addToBackStack(null);
                transaction.commit();
            }
        });

        btnSend.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                String repairDate = etDate.getText().toString();
                String repairTime = etTime.getText().toString();

                if(etDate.getText().toString().isEmpty() || etTime.getText().toString().isEmpty()){
                    Toast.makeText(RepairBookingActivity.this, "Fill in all the fields", Toast.LENGTH_SHORT).show();
                    System.out.println("Fill in all the fields");
                } else {
                    ReparaTechSingleton.getInstance(RepairBookingActivity.this).bookingRequest(repairDate, repairTime); //vamos buscar a instancia do ReparaTechSingleton e chamamos o metodo repairRequest
                    Toast.makeText(RepairBookingActivity.this, "Repair request sent successfully", Toast.LENGTH_SHORT).show();
                    System.out.println("Repair request sent successfully");
                    finish();
                }
            }
        });
    }

    public boolean onOptionItemSelected(MenuItem item){
        if(item.getItemId() == android.R.id.home){
            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    private void showTimeDialog(final EditText etTime){
        final Calendar calendar = Calendar.getInstance();

        TimePickerDialog.OnTimeSetListener timeSetListener= new TimePickerDialog.OnTimeSetListener() {
            @Override
            public void onTimeSet(TimePicker view, int hourOfDay, int minute) {
                calendar.set(Calendar.HOUR_OF_DAY,hourOfDay);
                calendar.set(Calendar.MINUTE,minute);
                if(hourOfDay < 9 || hourOfDay > 18){
                    Toast.makeText(RepairBookingActivity.this, getString(R.string.choose_an_hour_between_9am_and_18pm), Toast.LENGTH_SHORT).show();
                } else {
                    SimpleDateFormat simpleDateFormat = new SimpleDateFormat("HH:mm");
                    etTime.setText(simpleDateFormat.format(calendar.getTime()));
                }
            }
        };
        new TimePickerDialog(RepairBookingActivity.this,timeSetListener,calendar.get(Calendar.HOUR_OF_DAY),
                calendar.get(Calendar.MINUTE), false).show();
    }

    private void showDateDialog(EditText etDate) {
        Calendar calendar = Calendar.getInstance();

        DatePickerDialog.OnDateSetListener dateSetListener = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                calendar.set(Calendar.YEAR,year);
                calendar.set(Calendar.MONTH,month);
                calendar.set(Calendar.DAY_OF_MONTH,dayOfMonth);

                int dayOfWeek = calendar.get(Calendar.DAY_OF_WEEK);
                if (dayOfWeek == Calendar.SATURDAY || dayOfWeek == Calendar.SUNDAY) {
                    Toast.makeText(RepairBookingActivity.this, "please_choose_a_weekday", Toast.LENGTH_SHORT).show();
                } else {
                    SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd");
                    etDate.setText(simpleDateFormat.format(calendar.getTime()));
                }

            }
        };
        new DatePickerDialog(RepairBookingActivity.this,dateSetListener,calendar.get(Calendar.YEAR),
                calendar.get(Calendar.MONTH),calendar.get(Calendar.DAY_OF_MONTH)).show();
    }

    @Override
    public void onValidateBooking(boolean isValid) {
        if(isValid){
            Toast.makeText(this, "repair_request_sent_successfully", Toast.LENGTH_SHORT).show();
            finish();
        } else {
            Toast.makeText(this, "error_sending_repair_request", Toast.LENGTH_SHORT).show();
        }
    }
}