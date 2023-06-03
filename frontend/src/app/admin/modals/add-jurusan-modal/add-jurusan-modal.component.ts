import { Component, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-add-jurusan-modal',
  templateUrl: './add-jurusan-modal.component.html',
  styleUrls: ['./add-jurusan-modal.component.scss'],
})
export class AddJurusanModalComponent implements OnInit {
  form: any = {};
  constructor(
    private modalController: ModalController,
    private toastController: ToastController
  ) { }

  ngOnInit() { }

  close() {
    this.modalController.dismiss();
  }

  async create() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/jurusan`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify(this.form)
      });

      const json = await res.json();
      if (res.status !== 201) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });

        return;
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.modalController.dismiss();
      });
    } catch (error) {
      console.log(error);
    }
  }
}
