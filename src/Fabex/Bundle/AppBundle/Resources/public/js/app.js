$(document).ready(function () {
    $('body').on('click', '.toggleDownloaded', function () {
        /**
         * TODO FIXME
         **/
        var url = '/app_dev.php' + Routing.generate('fabex_app_toggle_downloaded_episode', {
                'serie': $(this).data('serie'),
                'season': $(this).data('season'),
                'episode': $(this).data('episode')
            });
        var $self = $(this);
        $.ajax({
            url: url,
            success: function () {
                if ($self.data('downloaded') == '1') {
                    $self.data('downloaded', 0);
                    $self.closest('tr').removeClass('bg-success').addClass('bg-danger');
                    return
                }
                $self.data('downloaded', 1);
                $self.closest('tr').removeClass('bg-danger').addClass('bg-success');
            }
        });
    })
});
