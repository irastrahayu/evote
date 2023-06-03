import { Component, Input, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { KandidatDetailModalComponent } from '../modal/kandidat-detail-modal/kandidat-detail-modal.component';

@Component({
  selector: 'app-event-details',
  templateUrl: './event-details.page.html',
  styleUrls: ['./event-details.page.scss'],
})
export class EventDetailsPage implements OnInit {
  @Input() data: any;
  isOpen = false;
  eventMessage = '';
  selectedSegment = 'kandidat';
  canReload: any;

  constructor(private modalCtrl: ModalController) { }

  ngOnInit() {
    const startDate = new Date(this.data.tanggal_mulai);
    const endDate = new Date(this.data.tanggal_selesai);

    const now = new Date();
    if (now >= startDate && now <= endDate) {
      this.isOpen = true;
    } else {
      if (now < startDate) {
        this.eventMessage = 'Event belum dimulai';
      }

      if (now > endDate) {
        this.eventMessage = 'Event sudah berakhir';
      }
    }
  }

  async kandidatDetail(data: any) {
    const kandidat = await this.modalCtrl.create({
      component: KandidatDetailModalComponent,
      componentProps: {
        data,
        isVoted: this.data.already_vote,
        isClosed: !this.isOpen
      }
    })

    kandidat.present();

    kandidat.onDidDismiss().then((data) => {
      if (data.data === 'voted') {
        this.data.already_vote = true;
        this.canReload = true;
      }
    })
  }

  close() {
    this.modalCtrl.dismiss({
      reload: this.canReload
    });
  }
}
