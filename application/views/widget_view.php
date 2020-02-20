<style>
    #rbs-open_widget {
        font-size: 24px;
        outline: none;
        background-color: #ffffff;
        border: 1px solid #ababab;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        color: #545454;
        width: 250px;
        height: 50px;
        position: relative;
        top: calc(50% - 25px);
        left: calc(50% - 125px);
        transition: all 0.5s ease 0s;
    }
    #rbs-open_widget:hover {
        background-color: #ababab;
        color: #ffffff;
        transition: all 0.5s ease 0s;
    }
</style>
<button id="rbs-open_widget">Открыть виджет</button>
<script src="/o-widget/rbs-widget.js?v=<?=time();?>"></script>