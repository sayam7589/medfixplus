<form name="closejob" id="closejob" action="{{ route('closejob', $repair->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b>ปิดงาน Serial No. {{ $inv->inv_serial_number }}</b>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($repair->medfix_pic != 0)
                    <img src="{{ asset('storage/' . $repair->medfix_pic) }}" alt="Uploaded Image" style="max-width: 300px;"><br>
                    @endif
                    วันที่แจ้งซ่อม: {{toThaiDateFormat($repair->medfix_ticket_date)}}<br>
                    อาการเบื้องต้น: {{$repair->medfix_detail}}<br>
                    เจ้าของเครื่อง: {{$repair->prefix->prefix_short.$repair->medfix_owner_fname.' '.$repair->medfix_owner_lname}}<br>
                    ผู้แจ้ง: {{ $repair->user->rank.$repair->user->fname.' '.$repair->user->lname }}<br>
                    หน่วย/สังกัด: {{ $repair->medfix_user_org }}<br>
                    เบอร์โทร: {{ $repair->medfix_tel }}<br><hr>
                    <div class="mb-3">
                        <label for="voicename" class="form-label">ช่างซ่อม</label>
                        <input type="hidden" name="inv_id" value="{{$repair->inv_id }}">
                        <input type="text" class="form-control" id="voicename" name="voicename" value="{{ session()->get('user_rank').session()->get('user_fname').' '.session()->get('user_lname') }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="issue" class="form-label">ผลการตรวจสอบพบว่า</label>
                        <select class="form-control" id="issue" name="issue">
                            @foreach ($issues as $issue)
                                <option value="{{ $issue->id }}">{{ $issue->issue_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="solving" class="form-label">แก้ปัญหาโดย</label>
                        <select class="form-control" id="solving" name="solving">
                            @foreach ($solvings as $solving)
                                <option value="{{ $solving->id }}">{{ $solving->solving_title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment"
                            class="form-label">หมายเหตุ</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">สถานะ</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">ซ่อมแล้ว</option>
                            <option value="2">ส่งกลับหน่วย</option>
                            <option value="3">แทงชำรุด</option>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-warning btn-sm"><i class='fas fa-tools'></i> ปิดงาน</button>
                </div>
            </div>
        </div>
    </div>
</form>
