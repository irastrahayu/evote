import { Component, Input, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-jurusan-modal',
  templateUrl: './edit-jurusan-modal.component.html',
  styleUrls: ['./edit-jurusan-modal.component.scss'],
})
export class EditJurusanModalComponent implements OnInit {
  @Input() data: any;
  form: any = {};

  constructor(
    private modalController: ModalController,
    private toastController: ToastController
  ) { }

  ngOnInit() {
    this.form.nama = this.data.nama;
  }

  close() {
    this.modalController.dismiss();
  }

  async edit() {
    try {
      const res = await fetch(`${environment.BASE_URL}admin/jurusan/${this.data.id}`, {
        method: 'PUT',
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
