<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">访问统计</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th></th>
                    <th>总访问量</th>
                    <th>日访问量</th>
                    <th>周访问量</th>
                    <th>月访问量</th>
                    <th>年访问量</th>
                </tr>
                <tr>
                    <td width="120px">文章</td>
                    <td>{{$visits["article"]["total"]}}</td>
                    <td>{{$visits["article"]["day"]}}</td>
                    <td>{{$visits["article"]["week"]}}</td>
                    <td>{{$visits["article"]["month"]}}</td>
                    <td>{{$visits["article"]["year"]}}</td>
                </tr>
                <tr>
                    <td width="120px">标签</td>
                    <td>{{$visits["tag"]["total"]}}</td>
                    <td>{{$visits["tag"]["day"]}}</td>
                    <td>{{$visits["tag"]["week"]}}</td>
                    <td>{{$visits["tag"]["month"]}}</td>
                    <td>{{$visits["tag"]["year"]}}</td>
                </tr>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
</div>