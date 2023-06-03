import { Component } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { EventDetailsPage } from '../event-details/event-details.page';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
  data: any = [];
  alreadyVoteData: any = [];
  constructor(
    private modalCtrl: ModalController,
    private toastController: ToastController
  ) { }

  ngOnInit() {
    this.getAllEvents();
  }

  async eventDetails(data: any) {
    const modal = await this.modalCtrl.create({
      component: EventDetailsPage,
      componentProps: {
        data: data
      }
    });

    modal.present();

    modal.onDidDismiss().then((a) => {
      if (a.data.reload) {
        this.getAllEvents();
      }
    });

  }

  async getAllEvents() {
    try {
      const res = await fetch(`${environment.BASE_URL}pemilihan`, {
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

      this.data = json.data;

      // filter if user has voted
      this.alreadyVoteData = this.data.filter((item: any) => item.already_vote);
    } catch (error: any) {
      this.toastController.create({
        message: error.message,
        duration: 2000
      }).then(toast => toast.present());
    }
  }
}
