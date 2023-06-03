import { Component, OnInit } from '@angular/core';
import { ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-activity',
  templateUrl: './activity.page.html',
  styleUrls: ['./activity.page.scss'],
})
export class ActivityPage implements OnInit {
  selectedSegment = 'upcoming';
  activities: any;
  constructor(
    private toastController: ToastController,

  ) { }

  ngOnInit() {
    this.getAllEvents();
  }

  async getAllEvents() {
    try {
      const res = await fetch(`${environment.BASE_URL}pemilihan/status`, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000
        }).then(toast => toast.present());
      }

      this.activities = json.data;

    } catch (error: any) {
      this.toastController.create({
        message: error.message,
        duration: 2000
      }).then(toast => toast.present());
    }
  }

  activityDetail(data: any) {
    console.log(data);
  }

  ngOnDestroy() {
    console.log('destroy');
  }
}
