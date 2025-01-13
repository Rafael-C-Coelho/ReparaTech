package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.text.SimpleDateFormat;
import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;

public class MyBookingAdapter extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<MyBooking> myBookings;

    public MyBookingAdapter(Context context, ArrayList<MyBooking> myBookings) {
        this.context = context;
        this.myBookings = myBookings;
    }
    @Override
    public int getCount() {
        return myBookings.size();
    }

    @Override
    public Object getItem(int i) {
       return myBookings.get(i);
    }

    @Override
    public long getItemId(int i) {
        return myBookings.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if (view == null) {
            view = inflater.inflate(R.layout.item_calendar, null);
        }
        ViewHolderList viewHolderList = (ViewHolderList) view.getTag();
        if (viewHolderList == null){
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }
        viewHolderList.update(myBookings.get(i));

        return view;
    }

    private class ViewHolderList {
        private TextView tvDate, tvTime, tvStatus;

        public ViewHolderList(View view){
            tvDate = view.findViewById(R.id.tvDate);
            tvTime = view.findViewById(R.id.tvTime);
            tvStatus = view.findViewById(R.id.tvStatus);
        }
        public void update(MyBooking myBooking) {
            SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
            SimpleDateFormat timeFormat = new SimpleDateFormat("HH:mm");

            tvDate.setText(myBooking.getDate().toString());
            tvTime.setText(myBooking.getTime().toString());
            tvStatus.setText(myBooking.getStatus());
        }
    }
}

